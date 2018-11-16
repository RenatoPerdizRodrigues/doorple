<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Morador;
use App\Veiculo;
use Hash;
use Image;
use File;

//Classe de acesso às funções de CRUD de veículos de moradores
class Veiculo_MoradorController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
    }

    //Função de acesso ao index de todos os veículos cadastrados
    public function index(){
        $veiculos_morador = Veiculo::all();
        return view('admin.veiculo_morador-creation.index')->with('veiculos_morador',$veiculos_morador);
    }

    //Mostra o formulário de criação de novos veículos
    public function create($id)
    {
        $morador = Morador::find($id);
        return view('admin.veiculo_morador-creation.create')->withMorador($morador);
    }

    //Salva o novo veículo de morador no banco de dados
    public function store(Request $request)
    {
        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'type' => 'required|min:4',
            'license_plate' => 'required|min:6',
            'color' => 'required',
            'morador_id' => 'exists:moradores,id'
        ));

        //Criação do modelo e salvamento das mudanças
        $veiculo_morador = new Veiculo();
        $veiculo_morador->type = $request->type;
        $veiculo_morador->license_plate = $request->license_plate;
        $veiculo_morador->color = $request->color;
        $veiculo_morador->morador_id = $request->morador_id;
        $veiculo_morador->save();

        //Redirecionamento
        return redirect()->route('admin.dashboard');
    }

    //Busca um veículo e redireciona para a página de show
    public function search(Request $request)
    {   
        $veiculo_morador = Veiculo::where('license_plate', $request->license_plate)->get();
        return redirect()->route('veiculo_morador.show', $veiculo_morador[0]->id);
    }

    //Mostra um veículo
    public function show($id)
    {
        $veiculo_morador = Veiculo::find($id);
        return view('admin.veiculo_morador-creation.show')->with('veiculo_morador', $veiculo_morador);
    }

    //Mostra formulário de edição
    public function edit($id)
    {
        $veiculo_morador = Veiculo::find($id);
        return view('admin.veiculo_morador-creation.edit')->with('veiculo_morador', $veiculo_morador);
    }

    //Salva as alterações da edição
    public function update(Request $request, $id)
    {
        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'type' => 'required|min:4',
            'license_plate' => 'required|min:6',
            'color' => 'required',
            'morador_id' => 'exists:moradores,id'
        ));

        //Criação do modelo e salvamento das mudanças
        $veiculo_morador = Veiculo::find($id);
        $veiculo_morador->type = $request->type;
        $veiculo_morador->license_plate = $request->license_plate;
        $veiculo_morador->color = $request->color;
        $veiculo_morador->morador_id = $request->morador_id;
        $veiculo_morador->save();

        //Redirecionamento
        return redirect()->route('admin.dashboard');
    }

    public function delete($id){
        $veiculo_morador = Veiculo::find($id);
        return view('admin.veiculo_morador-creation.delete')->with('veiculo_morador', $veiculo_morador);
    }

    //Deleta o veículo do morador
    public function destroy($id)
    {
        $veiculo_morador = Veiculo::find($id);
        $veiculo_morador->delete();

        return redirect()->route('admin.dashboard');
    }
}
