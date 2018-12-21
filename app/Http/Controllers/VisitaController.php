<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visita;
use App\Config;
use App\Visitante;
use App\Bloco;
use App\Apartamento;
use App\Morador;
use Session;

class VisitaController extends Controller
{
    //Construct que permite acesso apenas a usuários logados
    public function __construct(){
        $this->middleware('multiView')->except('create', 'store', 'leave');
        $this->middleware('auth')->except('index', 'search');
    }
    
    //Mostra todas as visitas do dia, paginadas em 10, junto das configurações para verificar se o condomínio permite o registro de carros para visitantes
    public function index($date = null)
    {
        $configs = Config::all();
        if ($date){
            $visitas = Visita::whereDate('created_at', $date)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $visitas = Visita::whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->paginate(10);
        }
        
        return view('user.visita-creation.index')->withVisitas($visitas)->withConfigs($configs);
    }

    //Mostra formulários da visita, deve passar as configs para definir se é possível cadastrar veículo de visitante
    public function create($id, $apartamento, $bloco, $placa = null, $modelo = null)
    {
        //Deve checar se o usuário não alterou o bloco e o apartamento para algum que não tenha visitante
        $morador = Morador::where([['apartamento_id' , $apartamento],['bloco_id', $bloco]])->get();

        if($morador->isEmpty()){
            Session::flash('warning', 'Apartamento selecionado não possui morador!');
            return redirect()->route('vst.main');
        }

        $configs = Config::all();

        //Deve checar se o usuário não alterou o id do visitante para algum que não exista
        $visitante = Visitante::where('id', $id)->first();
        if($visitante == null){
            Session::flash('warning', 'Visitante selecionado não existe!');
            return redirect()->route('vst.main');
        }

        //Deve checar se o visitante já não está estacionado no veículo
        $visita = Visita::where([['visitante_id', $visitante->id], ['vehicle_parked', 1]])->first();
        if ($visita != null && $visita->vehicle_parked == 1){
            Session::flash('warning', 'Não é possível cadastrar uma nova visita para este visitante, pois o mesmo já consta como estacionado no condomínio.');
            return redirect()->route('vst.main');
        }

        $blocos = Bloco::all();
        $apartamentos = Apartamento::all();
        return view('user.visita-creation.create')->withVisitante($visitante)->withApartamento($apartamento)->withBloco($bloco)->withPlaca($placa)->withModelo($modelo)->withBlocos($blocos)->withApartamentos($apartamentos)->withConfigs($configs);
    }

    //Salva dados da visita
    public function store(Request $request)
    {
        $this->validate($request, array(
            'visitante->id', 'exists:visitante, id',
            'apartamento_id', 'exists:apartamento, id',
            'bloco_id', 'exists:bloco, id',
            'vehicle_model' => 'nullable|in:'."Moto".","."Carro",
            'vehicle_license_plate' => 'nullable|min:8|max:8',
        ));

        //Checa se apartamento possui morador e pode ser visitado
        //Encontra o ID do apartamento
        $apartamento = Apartamento::where('id', $request->apartamento)->first();
        //Verifica se existe morador
        $morador = Morador::where([['apartamento_id' , $apartamento->id],['bloco_id', $request->bloco]])->get();
        if($morador->isEmpty()){
            Session::flash('warning', 'Apartamento selecionado não possui morador!');
            return redirect()->back()->withInput();
        }

        $visita = new Visita();
        $visita->visitante_id = $request->visitante_id;
        $visita->apartamento_id = $request->apartamento;
        $visita->bloco_id = $request->bloco;

        //Checa se está com veículo
        if ($request->vehicle_license_plate && $request->vehicle_model){
            $visita->vehicle_license_plate = strtoupper($request->vehicle_license_plate);
            $visita->vehicle_model = $request->vehicle_model;
            $visita->vehicle_parked = 1;
        }

        $visita->save();

        //Edita o último veículo utilizado pelo visitante
        $visitante = Visitante::find($request->visitante_id);
        if ($request->vehicle_license_plate != null && $visitante->vehicle_license_plate != strtoupper($request->vehicle_license_plate) ){
            $visitante->vehicle_license_plate = strtoupper($request->vehicle_license_plate);
            $visitante->vehicle_model = $request->vehicle_model;
        }

        $visitante->save();

        //Mensagem de sucesso
        Session::flash('success', 'Visita cadastrada com sucesso!');

        return redirect()->route('user.dashboard');
    }

    //Seleciona um dia para mostrar pesquisas
    public function search(Request $request){
        
        //Formata a data
        $valores = explode("/", $request->date);
        $date = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
        
        return redirect()->route('visita.index', $date);
    }

    //Registra a saída de veículo
    public function leave(Request $request){
        //Muda o valor que indica que veículo está no condomínio
        $visita = Visita::find($request->id);
        $visita->vehicle_parked = 0;

        $visita->save();

        //Mensagem de sucesso
        Session::flash('success', 'Saída de veículo registrada!');

        return redirect()->route('user.dashboard');
    }
}
