<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Morador;
use App\EntradaMorador;

//Controller de entrada de morador no condomínio
class EntradaMoradorController extends Controller
{
    //Retorna todas as entradas registradas
    public function index()
    {
        $entradas = EntradaMorador::whereDate('created_at', date('Y-m-d'))->get();
        return view('user.entrada-creation.index')->withEntradas($entradas);

    }

    public function search(Request $request){
        $entradas = EntradaMorador::whereDate('created_at', $request->date)->get();
        return view('user.entrada-creation.index')->withEntradas($entradas);
    }

    //Confirma o usuário a ter sua entrada registrada
    public function confirm(Request $request){

        $this->validate($request, array(
            'rg' => 'exists:moradores,rg'
        ));

        $morador = Morador::where('rg', $request->rg)->get();
        return view('user.entrada-creation.confirm')->withMorador($morador[0]);
    }

    //Retorna formulário de criação de nova entrada
    public function create()
    {
        return view('user.entrada-creation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $entrada = new EntradaMorador();
        $entrada->morador_id = $request->morador_id;
        $entrada->veiculo_id = $request->veiculo_id;
        $entrada->save();

        return redirect()->route('user.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
