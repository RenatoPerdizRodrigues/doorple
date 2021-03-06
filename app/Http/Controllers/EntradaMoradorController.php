<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Morador;
use App\EntradaMorador;
use Session;

//Controller de entrada de morador no condomínio
class EntradaMoradorController extends Controller
{
    //Retorna todas as entradas registradas, paginadas em 10
    public function index($date = null)
    {
        if ($date){
            $entradas = EntradaMorador::whereDate('created_at', $date)->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $entradas = EntradaMorador::whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->paginate(10);
        }
        return view('user.entrada-creation.index')->withEntradas($entradas)->withDate($date);

    }

    //Retorna a data pesquisada para o index
    public function search(Request $request){

        //Formata a data
        $valores = explode("/", $request->date);
        $date = $valores[2] . '-' . $valores[1] . '-' . $valores[0];

        return redirect()->route('entrada.index', $date);
    }

    //Confirma o usuário a ter sua entrada registrada
    public function confirm(Request $request){
        //Valida a request
        $this->validate($request, array(
            'rg' => 'required|min:1|max:12',
        ));

        $morador = Morador::where('rg', strtoupper($request->rg))->first();

        //Verifica se o morador existe
        if($morador == null){
            Session::flash('warning', 'Morador não encontrado!');
            return redirect()->route('entrada.create');
        }

        return view('user.entrada-creation.confirm')->withMorador($morador);
    }

    //Retorna formulário de criação de nova entrada
    public function create()
    {
        return view('user.entrada-creation.create');
    }

    //Insere a entrada no banco de dados
    public function store(Request $request)
    {
        //Valida a request
        $this->validate($request, array(
            'veiculo_id' => 'nullable|exists:veiculos_morador,id',
        ));

        $entrada = new EntradaMorador();
        $entrada->morador_id = $request->morador_id;
        $entrada->veiculo_id = $request->veiculo_id;
        $entrada->save();

        return redirect()->route('user.dashboard');
    }
}
