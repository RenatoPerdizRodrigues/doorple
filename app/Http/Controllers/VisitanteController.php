<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitante;
use App\Morador;
use App\Visita;
use App\Bloco;
use App\Apartamento;
use App\Config;
use Image;
use File;
use Session;

class VisitanteController extends Controller
{
    //Construct que permite acesso apenas a usuários logados
    public function __construct(){
        $this->middleware('auth');
    }

    //Método que mostra o formulário de busca inicial do usuário, que deve mostrar dinamicamente todos os apartamentos e blocos
    public function main(){
        //Todos os blocos e o primeiro bloco
        $blocos = Bloco::all();
        $primeirobloco = Bloco::first();         

        //Criação do array que receberá arrays de apartamentos de cada bloco, na ordem
        $apartamentos = array();

        foreach($blocos as $bloco){
            $apartamento = Apartamento::where('bloco_id', $bloco->id)->get();

            ${"prefixo_" . $bloco->prefix} = array();

            foreach($apartamento as $apartamento){
                array_push(${"prefixo_" . $bloco->prefix}, $apartamento);
            }

            array_push($apartamentos, ${"prefixo_" . $bloco->prefix});
        }

        //Array com um set inicial de apartamento do primeiro bloco, para usar como default
        $apartamentosBlocoInicial = Apartamento::where('bloco_id', $primeirobloco->id)->get();

        return view('user.visitante-creation.search')->withBlocos($blocos)->withApartamentos($apartamentos)->withApartamentosBlocoInicial($apartamentosBlocoInicial);
    }

    //Método que checa se apartamento possui morador e busca visitantes já existentes para encaminhar para show ou create
    public function search(Request $request){
        //Checa se apartamento possui morador e pode ser visitado
        $morador = Morador::where([['apartamento_id' , $request->apartamento],['bloco_id', $request->bloco]])->get();

        if($morador->isEmpty()){
            Session::flash('warning', 'Apartamento selecionado não possui morador!');
            return redirect()->route('vst.main');
        }

        //Checa se visitante já existe ou deverá ser cadastrdo
        $visitante = Visitante::where('rg', $request->rg)->first();
        if($visitante == null){
            //Precisa redirecionar para a criação de visitante

            Session::flash('warning', 'Visitante não encontrado!');
            return view('user.visitante-creation.next')->withRg($request->rg)->withBlocovisita($request->bloco)->withApartamentovisita($request->apartamento);
        } else {
            //Precisa redirecionar para a criação de visita

            Session::flash('success', 'Visitante encontrado!');
            if ($visitante->vehicle_license_plate != null && $visitante->vehicle_model != null){
                return redirect()->route('visita.create', [$visitante->id, $request->apartamento, $request->bloco, $visitante->vehicle_license_plate, $visitante->vehicle_model]);
            } else {
                return redirect()->route('visita.create', [$visitante->id, $request->apartamento, $request->bloco]);
            }
            
        }
    }

    //Retorna todos os visitantes cadastrados, paginados em 10
    public function index()
    {
        $visitantes = Visitante::paginate(10);
        return view('user.visitante-creation.index')->withVisitantes($visitantes);
    }

    //Encontra visitante específico no índex
    public function find(Request $request){
        $visitante = Visitante::where('rg', $request->rg)->first();

        if($visitante == null){
            Session::flash('warning', 'Visitante não encontrado!');
            return redirect()->route('vst.index');
        }

        return redirect()->route('vst.show', $visitante);
    }

    //Mostra o formulário de criação de novo visitante, com as configurações para definir se o cadastro de veículos está ativado para visitante
    public function create($rg, $bloco, $apartamento)
    {
        //Deve checar se o morador não alterou o bloco e o apartamento para algum que não tenha visitante
        $morador = Morador::where([['apartamento_id' , $apartamento],['bloco_id', $bloco]])->get();

        if($morador->isEmpty()){
            Session::flash('warning', 'Apartamento selecionado não possui morador!');
            return redirect()->route('vst.main');
        }

        $configs = Config::all();
        $blocos = Bloco::with('apartamentos')->get();
        return view('user.visitante-creation.create')->withRg($rg)->withBlocovisita($bloco)->withApartamentovisita($apartamento)->withBlocos($blocos)->withConfigs($configs);
    }

    //Salva o novo visitante no banco de dados
    public function store(Request $request)
    {
        //Valida os dados
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'surname' => 'required|min:3|max:35',
            'rg' => 'required|min:1|max:12|unique:moradores,rg',
            'birthdate' => 'required|before:'.date('d-m-Y'),
            'vehicle_model' => 'nullable|in:'."Moto".","."Carro",
            'vehicle_license_plate' => 'nullable|min:8|max:8',
        ));

        //Cria o objeto e salva
        $visitante = new Visitante();
        $visitante->name = $request->name;
        $visitante->surname = $request->surname;
        $visitante->rg = $request->rg;
        $visitante->birthdate = $request->birthdate;
        
        //Salva a imagem se necessário
        if ($request->hasfile('picture')){
            $picture = $request->file('picture');
            $filename = time() . '.' . $picture->getClientOriginalExtension();
            $location = public_path('images/visitante/' . $filename);
            Image::make($picture)->resize(150, 250)->save($location);
            
            $visitante->picture = $filename;
        } else {
            $visitante->picture = '1.jpg';
        }

        //Caso tenha digitado a placa mas não o modelo, retorna
        if(!is_null($request->vehicle_license_plate) && is_null($request->vehicle_model)){
            Session::flash('warning', 'É preciso cadastrar o modelo do veículo!');
            return redirect()->route('vst.create', [$request->rg, $request->bloco, $request->apartamento]);
        }

        //Salva o carro se necessário
        if($request->vehicle_license_plate && $request->vehicle_model){
            $visitante->vehicle_license_plate = $request->vehicle_license_plate;
            $visitante->vehicle_model = $request->vehicle_model;
        }

        $visitante->save();

        //Mensagem de sucesso
        Session::flash('success', 'Visitante cadastrado!');

        //Deve redirecionar para a criação de visita, com ID do visitante, apartamento e bloco e informações do carro
        if ($request->vehicle_license_plate != null && $request->vehicle_model != null){
            return redirect()->route('visita.create', [$visitante->id, $request->apartamento, $request->bloco, $request->vehicle_license_plate, $request->vehicle_model]);
        } else {
            return redirect()->route('visita.create', [$visitante->id, $request->apartamento, $request->bloco]);
        }
        

    }

    //Mostra o perfil do visitante, com configurações para verificar se o condomínio permite o cadastro de veículos de visitante
    public function show($id)
    {
        $configs = Config::all();
        $visitas = Visita::where('visitante_id', $id)->get();
        $visitante = Visitante::find($id);

        if($visitante == null){
            Session::flash('warning', 'Visitante não encontrado!');
            return redirect()->route('vst.index');
        }

        return view('user.visitante-creation.show')->withVisitante($visitante)->withVisitas($visitas)->withConfigs($configs);
    }

    //Mostra formulário de edição de visitante, com configs para verificar se o condomínio permite cadastro de veículos
    public function edit($id)
    {
        $configs = Config::all();
        $visitante = Visitante::find($id);

        //Verifica se usuário não alterou o ID do visitante para algum que não existe
        if($visitante == null){
            Session::flash('warning', 'Visitante não encontrado!');
            return redirect()->route('vst.index');
        }

        return view('user.visitante-creation.edit')->withVisitante($visitante)->withConfigs($configs);
    }

    //Salva as alterações feitas no visitante
    public function update(Request $request, $id)
    {
        //Valida os dados
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'surname' => 'required|min:3|max:35',
            'rg' => 'required|min:1|max:12|unique:visitantes,rg,'.$id,
            'birthdate' => 'required|before:'.date('d-m-Y'),
            'vehicle_model' => 'nullable|in:'."Moto".","."Carro",
            'vehicle_license_plate' => 'nullable|min:8|max:8',
        ));

        //Cria o objeto e salva
        $visitante = Visitante::find($id);
        $visitante->name = $request->name;
        $visitante->surname = $request->surname;
        $visitante->rg = $request->rg;
        $visitante->birthdate = $request->birthdate;
        
        //Salva a imagem se necessário
        if($request->hasFile('picture')){
            $picture = $request->file('picture');
            $filename = time() . '.' . $picture->getClientOriginalExtension();
            $location = public_path('images/visitante/' . $filename);
            Image::make($picture)->resize(150, 250)->save($location);

            //Deleta a imagem inicial
            if ($visitante->picture != '1.jpg'){ 
                File::delete(public_path('images/visitante/'.$visitante->picture));
            }

            $visitante->picture = $filename;
        }

        //Caso tenha digitado a placa mas não o modelo, retorna
        if(!is_null($request->vehicle_license_plate) && is_null($request->vehicle_model)){
            Session::flash('warning', 'É preciso cadastrar o modelo do veículo!');
            return redirect()->route('vst.edit', $id);
        }

        //Salva o carro se necessário
        if($request->vehicle_license_plate && $request->vehicle_model){
            $visitante->vehicle_license_plate = $request->vehicle_license_plate;
            $visitante->vehicle_model = $request->vehicle_model;
        }

        //Mensagem de sucesso
        Session::flash('success', 'Visitante editado!');

        $visitante->save();

        return redirect()->route('vst.show', $visitante->id);
    }

    //Retorna formulário de delete de visitante
    public function delete($id){
        $visitante = Visitante::find($id);

        //Verifica se o visitante existe
        if($visitante == null){
            Session::flash('warning', 'Visitante não encontrado!');
            return redirect()->route('vst.index');
        }

        return view('user.visitante-creation.delete')->withVisitante($visitante);
    }

    //Deleta todos os visitantes e visitas relacionadas a ele
    public function destroy($id)
    {
        $visitante = Visitante::find($id);
        
        //Verifica se o visitante existe
        if($visitante == null){
            Session::flash('warning', 'Visitante não encontrado!');
            return redirect()->route('vst.index');
        }

        //Verifica se o visitante tem visitas registradas
        $visitas = Visita::where('visitante_id', $id)->get();

        if(!$visitas->isEmpty()){
            Session::flash('warning', 'Nâo é possível deletar o perfil de visitante pois o mesmo tem visitas atreladas!');
            return redirect()->route('vst.show', $id);
        }

        if ($visitante->picture != '1.jpg'){ 
            File::delete(public_path('images/visitante/'.$visitante->picture));
        }

        $visitante->delete();

        //Mensagem de sucesso
        Session::flash('success', 'Visitante excluído!');

        return redirect()->route('user.dashboard');
    }
}
