<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitante;
use App\Morador;
use App\Visita;
use App\Bloco;
use App\Apartamento;
use Image;
use File;
use Session;

class VisitanteController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth');
    }

    //Método que mostra o formulário de busca inicial do usuário
    public function main(){
        $blocos = Bloco::with('apartamentos')->get();
        return view('user.visitante-creation.search')->withBlocos($blocos);
    }
    /*Método que checa se apartamento possui morador e
     busca visitantes já existentes para encaminhar para show ou create*/
    public function search(Request $request){
        //Checa se apartamento possui morador e pode ser visitado
        //Encontra o ID do apartamento
        $apartamento = Apartamento::where([['apartamento', $request->apartamento],['bloco_id', $request->bloco]])->first();
        //Verifica se existe morador
        $morador = Morador::where([['apartamento_id' , $apartamento->id],['bloco_id', $request->bloco]])->get();
        if($morador->isEmpty()){
            Session::flash('success', 'Apartamento selecionado não possui morador!');
            return redirect()->route('vst.main');
        }

        $visitante = Visitante::where('rg', $request->rg)->get();
        if($visitante->isEmpty()){
            //Precisa redirecionar para a criação de visitante

            Session::flash('success', 'Visitante não encontrado!');
            return view('user.visitante-creation.next')->withRg($request->rg)->withBlocovisita($request->bloco)->withApartamentovisita($apartamento->id);
        } else {
            //Precisa redirecionar para a criação de visita

            Session::flash('success', 'Visitante encontrado!');
            return redirect()->route('visita.create', [$visitante[0]->id, $apartamento->id, $request->bloco, $visitante[0]->vehicle_license_plate, $visitante[0]->vehicle_model]);
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
        $visitante = Visitante::where('rg', $request->rg)->get();
        return redirect()->route('vst.show', $visitante[0]);
    }

    //Mostra o formulário de criação de novo visitante
    public function create($rg, $bloco, $apartamento)
    {
        $blocos = Bloco::with('apartamentos')->get();
        return view('user.visitante-creation.create')->withRg($rg)->withBlocovisita($bloco)->withApartamentovisita($apartamento)->withBlocos($blocos);
    }

    //Salva o novo visitante no banco de dados
    public function store(Request $request)
    {
        //Valida os dados
        $this->validate($request, array(
            'name' => 'required|min:2|max:35',
            'surname' => 'required|min:5|max:35',
            'rg' => 'required',
            'birthdate' => 'date'
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
            Image::make($picture)->resize(300, 400)->save($location);
            
            $visitante->picture = $filename;
        } else {
            $visitante->picture = '1.jpg';
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
        return redirect()->route('visita.create', [$visitante->id, $request->apartamento, $request->bloco, $request->vehicle_license_plate, $request->vehicle_model]);

    }

    //Mostra o perfil do visitante
    public function show($id)
    {
        $visitas = Visita::where('visitante_id', $id)->get();
        $visitante = Visitante::find($id);
        return view('user.visitante-creation.show')->withVisitante($visitante)->withVisitas($visitas);
    }

    //Mostra formulário de edição de visitante
    public function edit($id)
    {
        $visitante = Visitante::find($id);
        return view('user.visitante-creation.edit')->withVisitante($visitante);
    }

    //Salva as alterações feitas no visitante
    public function update(Request $request, $id)
    {
        //Valida os dados
        $this->validate($request, array(
            'name' => 'required|min:2|max:35',
            'surname' => 'required|min:5|max:35',
            'rg' => 'required',
            'birthdate' => 'date'
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
            Image::make($picture)->resize(300, 400)->save($location);

            //Deleta a imagem inicial
            if ($visitante->picture != '1.jpg'){ 
                File::delete(public_path('images/visitante/'.$visitante->picture));
            }

            $visitante->picture = $filename;
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
        return view('user.visitante-creation.delete')->withVisitante($visitante);
    }

    //Deleta todos os visitantes e visitas relacionadas a ele
    public function destroy($id)
    {
        $visitante = Visitante::find($id);
        $visitas = Visita::where('visitante_id', $id);

        if ($visitante->picture != '1.jpg'){ 
            File::delete(public_path('images/visitante/'.$visitante->picture));
        }

        $visitas->delete();
        $visitante->delete();

        //Mensagem de sucesso
        Session::flash('success', 'Visitante excluído!');

        return redirect()->route('user.dashboard');
    }
}
