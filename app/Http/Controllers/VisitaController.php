<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visita;
use App\Visitante;
use App\Bloco;
use App\Apartamento;

class VisitaController extends Controller
{
    //Mostra todas as visitas do dia
    public function index()
    {
        $visitas = Visita::whereDate('created_at', date('Y-m-d'))->get();
        return view('user.visita-creation.index')->withVisitas($visitas);
    }

    //Mostra formulários da visita
    public function create($id, $apartamento, $bloco, $placa = null, $modelo = null)
    {
        $visitante = Visitante::find($id);
        $bloco = Bloco::find($bloco);
        $apartamento = Apartamento::find($apartamento);
        return view('user.visita-creation.create')->withVisitante($visitante)->withApartamento($apartamento)->withBloco($bloco)->withPlaca($placa)->withModelo($modelo);
    }

    //Salva dados da visita
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

        //Checa se está com veículo
        if ($request->vehicle_license_plate && $request->vehicle_model){
            $visita->vehicle_license_plate = $request->vehicle_license_plate;
            $visita->vehicle_model = $request->vehicle_model;
            $visita->vehicle_parked = 1;
        }

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

    //Seleciona um dia para mostrar pesquisas
    public function search(Request $request){
        $visitas = Visita::whereDate('created_at', $request->date)->get();
        return view('user.visita-creation.index')->withVisitas($visitas);
    }

    //Mostra uma visita específica
    public function show($id)
    {
        //
    }

    //Mostra formulário de edição de visita
    public function edit($id)
    {
        //
    }

    //Salva a alteração da edição
    public function update(Request $request, $id)
    {
        //
    }

    //Deleta visita
    public function destroy($id)
    {
        //
    }
}
