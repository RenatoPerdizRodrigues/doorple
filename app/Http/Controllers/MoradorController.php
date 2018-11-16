<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Morador;
use App\Apartamento;
use Hash;
use Image;
use File;

//Classe de acesso às funções de CRUD moradores
class MoradorController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
    }

    //Função de acesso ao index de todos os moradores cadastrados
    public function index(){
        $moradores = Morador::all();
        return view('admin.morador-creation.index')->withMoradores($moradores);
    }

    //Mostra o formulário de criação de novos moradores
    public function create()
    {
        return view('admin.morador-creation.create');
    }

    //Salva o novo morador no banco de dados
    public function store(Request $request)
    {
        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'surname' => 'required|min:3|max:35',
            'rg' => 'required|min:6',
            'birthdate' => 'required',
            'ap' => 'exists:apartamentos,apartamento'
        ));

        //Criação do modelo e salvamento das mudanças
        $morador = new Morador();
        $morador->name = $request->name;
        $morador->surname = $request->surname;
        $morador->rg = $request->rg;
        $morador->birthdate = $request->birthdate;
        
        //Encontra a id do apartamento
        $apartamento = Apartamento::where('apartamento', $request->ap)->limit(1)->get();
        
        //Salva o id no objeto Morador
        $morador->apartamento_id = $apartamento[0]->id;

        //Salva imagem se necessário, com filename feito pela timestamp, com a extensão original e salva o filename no bd
        if ($request->hasfile('picture')){
            $picture = $request->file('picture');
            $filename = time() . '.' . $picture->getClientOriginalExtension();
            $location = public_path('images/morador/' . $filename);
            Image::make($picture)->resize(300, 400)->save($location);
            
            $morador->picture = $filename;
        }

        $morador->save();

        //Redirecionamento
        return redirect()->route('admin.dashboard');
    }

    //Busca um morador e redireciona para a página de show
    public function search(Request $request)
    {   
        $morador = Morador::where('rg', $request->rg)->get();
        return redirect()->route('morador.show', $morador[0]->id);
    }

    //Mostra um admin
    public function show($id)
    {
        $morador = Morador::find($id);
        return view('admin.morador-creation.show')->withMorador($morador);
    }

    //Mostra formulário de edição
    public function edit($id)
    {
        $morador = Morador::find($id);
        return view('admin.morador-creation.edit')->withMorador($morador);
    }

    //Salva as alterações da edição
    public function update(Request $request, $id)
    {
        $morador = Morador::find($id);        

        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'name' => 'required|min:3|max:35',
            'surname' => 'required|min:3|max:35',
            'rg' => 'required|min:6',
            'birthdate' => 'required',
            'ap' => 'exists:apartamentos,apartamento'
        ));

        //Criação do modelo e save das mudanças
        $morador = Morador::find($id);
        $morador->name = $request->name;
        $morador->surname = $request->surname;
        $morador->rg = $request->rg;
        $morador->birthdate = $request->birthdate;
        
        //Encontra a id do apartamento
        $apartamento = Apartamento::where('apartamento', $request->ap)->limit(1)->get();
        
        //Salva o id no objeto Morador
        $morador->apartamento_id = $apartamento[0]->id;

        //Edita imagem se necessário, com filename feito pela timestamp, com a extensão original e salva o filename no bd
        if ($request->hasfile('picture')){

            $picture = $request->file('picture');
            $filename = time() . '.' . $picture->getClientOriginalExtension();
            $location = public_path('images/morador/' . $filename);
            Image::make($picture)->resize(300, 400)->save($location);
            
            //Deleta a foto original
            File::delete(public_path('images/morador/'.$morador->picture));

            $morador->picture = $filename;

        }

        $morador->save();

        //Redirecionamento
        return redirect()->route('admin.dashboard');
    }

    public function delete($id){
        $morador = Morador::find($id);
        return view('admin.morador-creation.delete')->withMorador($morador);
    }

    //Deleta o admin
    public function destroy($id)
    {
        $morador = Morador::find($id);
        File::delete(public_path('images/morador/'.$morador->picture));
        $morador->delete();

        return redirect()->route('admin.dashboard');
    }
}