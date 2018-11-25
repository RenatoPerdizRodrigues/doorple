<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitante;
use App\Bloco;
use App\Apartamento;

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
        if($visitante){
            //Precisa redirecionar para a criação de visita
            return redirect()->route('visita.create', [$visitante[0]->id, $request->apartamento, $request->bloco, $visitante[0]->vehicle_license_plate, $visitante[0]->vehicle_model]);
        } else {
            return view('user.visitante-creation.next')->withRg($request->rg)->withBlocovisita($request->bloco)->withApartamentovisita($request->apartamento);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($request->hasFile('picture')){
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitante = Visitante::find($id);
        return view('user.visitante-creation.show')->withVisitante($visitante);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
