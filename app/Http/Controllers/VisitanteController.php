<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visitante;

class VisitanteController extends Controller
{
    //Método que mostra o formulário de busca inicial do usuário
    public function main(){
        return view('user.visitante-creation.search');
    }
    //Método que busca visitantes já existentes para encaminhar para show ou create
    public function search(Request $request){
        $visitante = Visitante::find($request->rg);
        if($visitante){
            return redirect()->route('vst.show');
        } else {
            return view('user.visitante-creation.next')->withRg($request->rg);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($rg)
    {
        return view('user.visitante-creation.create')->withRg($rg);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
