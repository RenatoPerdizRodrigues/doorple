<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Morador;
use App\Apartamento;
use App\Bloco;
use App\EntradaMorador;
use App\Veiculo;
use Hash;
use Image;
use File;
use Session;

//Classe de acesso às funções de CRUD moradores
class MoradorController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('multiView')->except('create', 'store', 'edit', 'update', 'delete', 'destroy');
        $this->middleware('auth:admin')->except('search', 'show', 'index');
        $this->middleware('checkConfig');
    }

    //Função de acesso ao index de todos os moradores cadastrados, paginados em 10
    public function index(){
        $moradores = Morador::paginate(10);
        return view('admin.morador-creation.index')->withMoradores($moradores);
    }

    //Mostra o formulário de criação de novos moradores, deve mostrar blocos e apartamentos dinamicamente
    public function create()
    {
        //Mostra todos os blocos
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

        return view('admin.morador-creation.create')->withBlocos($blocos)->withApartamentos($apartamentos)->withApartamentosBlocoInicial($apartamentosBlocoInicial);
    }

    //Salva o novo morador no banco de dados
    public function store(Request $request)
    {        
        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'surname' => 'required|min:3|max:35',
            'rg' => 'required|min:1|max:12|unique:moradores,rg',
            'birthdate' => 'required|before:'.date('d-m-Y'),
            'ap' => 'exists:apartamentos,id',
            'bloco' => 'exists:blocos,id'
        ));

        //Reformata a data para formato brasileiro para inserção
        $valores = explode("-", $request->birthdate);
        $birthdate = $valores[0] . '/' . $valores[1] . '/' . $valores[2];

        //Criação do modelo e save das mudanças
        $morador = new Morador();
        $morador->name = $request->name;
        $morador->surname = $request->surname;
        $morador->rg = strtoupper($request->rg);
        $morador->birthdate = $birthdate;
        $morador->bloco_id = $request->bloco;
        $morador->apartamento_id = $request->ap;
        
        //Salva imagem se necessário, com filename feito pela timestamp, com a extensão original e salva o filename no bd
        if ($request->hasfile('picture')){
            $picture = $request->file('picture');
            $filename = time() . '.' . $picture->getClientOriginalExtension();
            $location = public_path('images/morador/' . $filename);
            Image::make($picture)->resize(170, 250)->save($location);
            
            $morador->picture = $filename;
        } else {
            $morador->picture = '1.jpg';
        }

        $morador->save();

        //Criação de mensagem de sucesso
        Session::flash('success', 'Morador cadastrado com sucesso!');

        //Redirecionamento
        return redirect()->route('morador.index');
    }

    //Busca um morador e redireciona para a página de show
    public function search(Request $request)
    {   
        $morador = Morador::where('rg', strtoupper($request->rg))->first();
        
        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('morador.index');
        }

        return redirect()->route('morador.show', $morador->id);
    }

    //Mostra um morador específico. Deve retornar as configurações para ver se deve permitir o cadastro de veículos
    public function show($id)
    {
        $morador = Morador::find($id);

        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('morador.index');
        }

        $entradas = EntradaMorador::where('morador_id', $id)->get();
        $configs = Config::all();
        
        return view('admin.morador-creation.show')->withMorador($morador)->withEntradas($entradas)->withConfigs($configs);
    }

    //Mostra formulário de edição de morador, que deve mostrar os apartamentos dinamicamente
    public function edit($id)
    {
        //Mostra todos os blocos
        $blocos = Bloco::all();

        $morador = Morador::find($id);

        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('morador.index');
        }

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
        $apartamentosBlocoInicial = Apartamento::where('bloco_id', $morador->bloco->id)->get();


        return view('admin.morador-creation.edit')->withMorador($morador)->withBlocos($blocos)->withApartamentos($apartamentos)->withApartamentosBlocoInicial($apartamentosBlocoInicial);;
    }

    //Salva as alterações da edição
    public function update(Request $request, $id)
    {
        $morador = Morador::find($id);        

        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('morador.index');
        }

        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'surname' => 'required|min:3|max:35',
            'rg' => 'required|min:1|max:12|unique:moradores,rg,'.$id,
            'birthdate' => 'required|before:'.date('d-m-Y'),
            'ap' => 'exists:apartamentos,id',
            'bloco' => 'exists:blocos,id'
        ));

        //Reformata a data para formato brasileiro para inserção
        $valores = explode("-", $request->birthdate);
        $birthdate = $valores[0] . '/' . $valores[1] . '/' . $valores[2];

        //Criação do modelo e save das mudanças
        $morador = Morador::find($id);
        $morador->name = $request->name;
        $morador->surname = $request->surname;
        $morador->rg = strtoupper($request->rg);
        $morador->birthdate = $birthdate;
        $morador->bloco_id = $request->bloco;
        $morador->apartamento_id = $request->ap;

        //Edita imagem se necessário, com filename feito pela timestamp, com a extensão original e salva o filename no bd
        if ($request->hasfile('picture')){

            $picture = $request->file('picture');
            $filename = time() . '.' . $picture->getClientOriginalExtension();
            $location = public_path('images/morador/' . $filename);
            Image::make($picture)->resize(170, 250)->save($location);
            
            //Deleta a foto original
            if ($morador->picture != '1.jpg'){
                File::delete(public_path('images/morador/'.$morador->picture));
            }
            
            $morador->picture = $filename;

        }

        $morador->save();

        //Criação de mensagem de sucesso
        Session::flash('success', 'Morador editado com sucesso!');

        //Redirecionamento
        return redirect()->route('morador.show', $morador->id);
    }

    //Retorna o formulário de exclusão de morador
    public function delete($id){
        $morador = Morador::find($id);

        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('morador.index');
        }

        return view('admin.morador-creation.delete')->withMorador($morador);
    }

    //Deleta o morador
    public function destroy($id)
    {
        $morador = Morador::find($id);

        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('morador.index');
        }

        //Deleta as entradas e veículos relacionados ao morador a ser deletado
        $entradas = EntradaMorador::where('morador_id', $morador->id)->delete();
        $veiculos = Veiculo::where('morador_id', $morador->id)->delete();

        //Verifica se deve deletar a foto do morador
        if ($morador->picture != '1.jpg'){
            File::delete(public_path('images/morador/'.$morador->picture));
        }
        $morador->delete();

        //Criação de mensagem de sucesso
        Session::flash('success', 'Morador, veículos e entradas deletados com sucesso!');

        return redirect()->route('morador.index');
    }
}
