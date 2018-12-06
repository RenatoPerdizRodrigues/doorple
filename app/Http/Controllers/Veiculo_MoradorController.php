<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Morador;
use App\Veiculo;
use Hash;
use Image;
use File;
use Session;

//Classe de acesso às funções de CRUD de veículos de moradores
class Veiculo_MoradorController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
    }

    //Função de acesso ao index de todos os veículos cadastrados, paginados em 10
    public function index(){
        $veiculos_morador = Veiculo::paginate(10);

        return view('admin.veiculo_morador-creation.index')->with('veiculos_morador',$veiculos_morador);
    }

    //Mostra o formulário de criação de novos veículos
    public function create($id)
    {
        $morador = Morador::find($id);

        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('morador.index');
        }

        return view('admin.veiculo_morador-creation.create')->withMorador($morador);
    }

    //Salva o novo veículo de morador no banco de dados
    public function store(Request $request)
    {
        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'vehicle_model' => 'required|in:'."Moto".","."Carro",
            'vehicle_license_plate' => 'required|min:8|max:8|unique:veiculos_morador,vehicle_license_plate',
            'morador_id' => 'exists:moradores,id'
        ));

        //Criação do modelo e save das mudanças
        $veiculo_morador = new Veiculo();
        $veiculo_morador->vehicle_model = $request->vehicle_model;
        $veiculo_morador->vehicle_license_plate = strtoupper($request->vehicle_license_plate);
        $veiculo_morador->morador_id = $request->morador_id;
        $veiculo_morador->save();

        //Mensagem de sucesso
        Session::flash('success', 'Veículo cadastrado com sucesso');

        //Redirecionamento
        return redirect()->route('veiculo_morador.index');
    }

    //Busca um veículo e redireciona para a página de show
    public function search(Request $request)
    {   
        $veiculo_morador = Veiculo::where('vehicle_license_plate', $request->license_plate)->first();

        //Verifica se o veículo existe
        if($veiculo_morador == null){
            Session::flash('warning', 'Veículo não encontrado!');
            return redirect()->route('veiculo_morador.index');
        }

        return redirect()->route('veiculo_morador.show', $veiculo_morador->id);
    }

    //Mostra um veículo
    public function show($id)
    {
        $veiculo_morador = Veiculo::find($id);

        //Verifica se o morador existe
        if($veiculo_morador == null){
            Session::flash('warning', 'Veículo não encontrado!');
            return redirect()->route('veiculo_morador.index');
        }

        return view('admin.veiculo_morador-creation.show')->with('veiculo_morador', $veiculo_morador);
    }

    //Mostra formulário de edição
    public function edit($id)
    {
        $veiculo_morador = Veiculo::find($id);

        //Verifica se o veículo existe
        if($veiculo_morador == null){
            Session::flash('warning', 'Veículo não encontrado!');
            return redirect()->route('veiculo_morador.index');
        }

        return view('admin.veiculo_morador-creation.edit')->with('veiculo_morador', $veiculo_morador);
    }

    //Salva as alterações da edição
    public function update(Request $request, $id)
    {        
        //Validação de dados do formulário, incluindo conferindo se o apartamento existe
        $this->validate($request, array(
            'vehicle_model' => 'required|in:'."Moto".","."Carro",
            'vehicle_license_plate' => 'required|min:8|max:8|unique:veiculos_morador,vehicle_license_plate,'.$id,
            'morador_id' => 'exists:moradores,id'
        ));

        //Criação do modelo e salvamento das mudanças
        $veiculo_morador = Veiculo::find($id);
        $veiculo_morador->vehicle_model = $request->vehicle_model;
        $veiculo_morador->vehicle_license_plate = strtoupper($request->vehicle_license_plate);
        $veiculo_morador->save();

        //Mensagem de sucesso
        Session::flash('success', 'Veículo editado com sucesso');

        //Redirecionamento
        return redirect()->route('veiculo_morador.show', $veiculo_morador->id);
    }

    public function delete($id){
        $veiculo_morador = Veiculo::find($id);

        //Verifica se o veículo existe
        if($veiculo_morador == null){
            Session::flash('warning', 'Veículo não encontrado!');
            return redirect()->route('veiculo_morador.index');
        }

        return view('admin.veiculo_morador-creation.delete')->with('veiculo_morador', $veiculo_morador);
    }

    //Deleta o veículo do morador
    public function destroy($id)
    {
        $veiculo_morador = Veiculo::find($id);

        //Verifica se o veículo existe
        if($veiculo_morador == null){
            Session::flash('warning', 'Veículo não encontrado!');
            return redirect()->route('veiculo_morador.index');
        }

        $veiculo_morador->delete();

        //Mensagem de sucesso
        Session::flash('success', 'Veículo deletado com sucesso');

        return redirect()->route('veiculo_morador.index');
    }
}
