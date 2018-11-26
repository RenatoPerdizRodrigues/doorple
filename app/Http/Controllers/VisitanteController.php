<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitante;
use App\Visita;
use App\Bloco;
use App\Apartamento;
use Image;
use File;

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
    //Método que busca visitantes já existentes para encaminhar para show ou create
    public function search(Request $request){

        $visitante = Visitante::where('rg', $request->rg)->get();
        if(!empty($visitante)){
            //Precisa redirecionar para a criação de visita
            return redirect()->route('visita.create', [$visitante[0]->id, $request->apartamento, $request->bloco, $visitante[0]->vehicle_license_plate, $visitante[0]->vehicle_model]);
        } else {
            return view('user.visitante-creation.next')->withRg($request->rg)->withBlocovisita($request->bloco)->withApartamentovisita($request->apartamento);
        }
    }

    //Retorna todos os visitantes cadastrados
    public function index()
    {
        $visitantes = Visitante::all();
        return view('user.visitante-creation.index')->withVisitantes($visitantes);
    }

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

        //Deve redirecionar para a criação de visita, com ID do visitante, apartamento e bloco e informações do carro
        return redirect()->route('visita.create', [$visitante->id, $request->apartamento, $request->bloco, $request->vehicle_license_plate, $request->vehicle_model]);

    }

    //Mostra o perfil do visitante
    public function show($id)
    {
        $visitante = Visitante::find($id);
        return view('user.visitante-creation.show')->withVisitante($visitante);
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

        return redirect()->route('user.dashboard');
    }
}
