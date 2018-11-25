<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visita;
use App\Visitante;
use App\Bloco;
use App\Apartamento;

class VisitaController extends Controller
{
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
    public function create($id, $apartamento, $bloco, $placa, $modelo)
    {
        $visitante = Visitante::find($id);
        $bloco = Bloco::find($bloco);
        $apartamento = Apartamento::find($apartamento);
        return view('user.visita-creation.create')->withVisitante($visitante)->withApartamento($apartamento)->withBloco($bloco)->withPlaca($placa)->withModelo($modelo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'visitante->id', 'exists:visitante, id',
            'apartamento_id', 'exists:apartamento, id',
            'bloco_id', 'exists:bloco, id'
        ));

        $visita = new Visita();
        $visita->visitante_id = $request->visitante_id;
        $visita->apartamento_id = $request->apartamento;
        $visita->bloco_id = $request->bloco;
        $visita->vehicle_license_plate = $request->vehicle_license_plate;
        $visita->vehicle_model = $request->vehicle_model;
        $visita->save();

        //Edita o último veículo utilizado pelo visitante
        $visitante = Visitante::find($request->visitante_id);
        if ($visitante->vehicle_license_plate != $request->vehicle_license_plate ){
            $visitante->vehicle_license_plate = $request->vehicle_license_plate;
        }

        if ($visitante->vehicle_model != $request->vehicle_model ){
            $visitante->vehicle_model = $request->vehicle_model;
        }

        $visitante->save();

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
