<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Apartamento;
use App\Morador;
use App\Bloco;
use Session;

class ConfigController extends Controller
{
    //Retorna a view de todos os apartamentos
    public function index($bloco = null){
        $blocos = Bloco::all();
        if ($bloco == null){
            $prefix = Bloco::first();
            $bloco = Bloco::where('prefix', $prefix->prefix)->get();
            $apartamentos = Apartamento::with('moradores')->where('bloco_id', $bloco[0]->id)->get();
        } else {
            $bloco = Bloco::where('prefix', $bloco)->get();
            $apartamentos = Apartamento::with('moradores')->where('bloco_id', $bloco[0]->id)->get();
        }
        //$apartamentos = Apartamento::with('moradores')->get();
        return view('admin.configuration.index')->withApartamentos($apartamentos)->withBlocos($blocos)->withBloco($bloco);
    }

    //Retorna o index com o bloco selecionado
    public function search(Request $request){
        return redirect()->route('admin.config.index', $request->bloco);
    }
    
    public function config(){
        return view('admin.configuration.config');
    }

    //Valida e insere dados de configuração inicial
    public function startConfig(Request $request){
        //Valida os dados do formulário de configuração
        $this->validate($request, array(
            'system_name' => 'required|min:3|max:20',
            'visitor_car' => 'required|boolean',
            'resident_registry' => 'required|boolean'
        ));

        //Insere os dados de configuração na tabela configs
        $config = new Config();
        $config->configured = 0;
        $config->system_name = $request->system_name;
        $config->visitor_car = $request->visitor_car;

        //Cálculo de tempo que o carro pode ficar no condomínio
        if ($request->minutes || $request->car_time_hours){
            if ($request->car_time_hours != null){
                $time = ($request->car_time_hours * 60) + $request->car_time_minutes;
                $config->car_time = $time;
            } elseif($request->car_time_minutes) {
                $config->car_time = $request->car_time_minutes;
            }
        }
        $config->resident_registry = $request->resident_registry;
        $config->save();

        //Redireciona para a configuração de apartamentos
        return redirect()->route('admin.config.ap');
    }

    //Retorna a view do formulário de configuração inicial
    public function apIndex(){
        return view('admin.configuration.config-ap');
    }

    //Retorna a a continuação do formulário de configuração
    public function apDetail(Request $request){
        $total = $request->total;
        $blocos = $request->blocos;
        //Descobre a quantidade de apartamentos por bloco, arredondando para cima
        $pbloco = $total / $blocos;
        $pbloco = ceil($pbloco);

        return view('admin.configuration.config-ap-2')->withTotal($total)->withBlocos($blocos)->withPblocos($pbloco);
    }

        //Retorna a visualização dos apartamentos
        public function apDetail2(Request $request){
            $total = $request->total;
            $blocos = $request->blocos;
            $pblocos = $request->pblocos;

            //Coloca apenas os apartamentos preenchidos
            $apartamentos = array();
            foreach($request->ap as $ap){
                if($ap != ""){
                    array_push($apartamentos, $ap);
                }
            }

            return view('admin.configuration.config-ap-3')->withTotal($total)->withBlocos($blocos)->withPblocos($pblocos)->withApartamentos($apartamentos);
        }

    //Valida dados de configuração final
    public function finishConfig(Request $request){
        //Insere todos os blocos e seus respectivos valores
        for($i = 1; $i <= $request->blocos; $i++){
            $bloco = new Bloco([
                'prefix' => $request['prefix'.$i]
            ]);

            $bloco->save();

            //Insere os apartamentos deste prefix
            foreach ($request['apartamento_'.$i] as $apartamento){
                if(!empty($apartamento)){
                    $ap = new Apartamento([
                        'apartamento' => $apartamento,
                        'bloco_id' => $bloco->id
                    ]);
    
                    $ap->save();
                }
            }
        }

        //Método que salva o booleano de configuração como true
            $config = Config::all();
            $config[0]->howmanyblocks = $request->howmanyblocks;
            $config[0]->configured = 1;
            $config[0]->save();

        //Mensagem de sucesso
        Session::flash('success', 'Configuração finalizada com sucesso!');
        
        return redirect()->route('admin.dashboard');
    }

    //Cria um apartamento individual
    public function create(){
        $blocos = Bloco::all();
        return view('admin.configuration.create')->withBlocos($blocos);
    }

    //Armazena apartamento individual referindo o bloco correto
    public function store(Request $request){

        //Salva os dados no objeto Apartamento
        $apartamento = new Apartamento();
        $apartamento->apartamento = $request->apartamento;
        $apartamento->bloco_id = $request->bloco_id;
        $apartamento->save();

        //Mensagem de sucesso
        Session::flash('success', 'Apartamento cadastrado com sucesso!');

        return redirect()->route('admin.config.index');
    }

    //Função que retorna a edição de configuração e apartamentos
    public function edit(){
        $blocos = Bloco::all();
        $configsAll = Config::all();
        $configs = $configsAll[0];

        //Retorna as horas e minutos permitidas pelo carro
        $decimal = $configs->car_time / 60;
        $horas = floor($decimal);
        $resto = $decimal - $horas;
        $minutos = $resto * 60;

        return view('admin.configuration.edit')->withBlocos($blocos)->withConfigs($configs)->withHoras($horas)->withMinutos($minutos);
    }

    //Função que edita as configurações
    public function update(Request $request){

        //Valida os dados
        $this->validate($request, array(
            'visitor_car' => 'boolean',
            'resident_registry' => 'boolean'
        ));
        //Edita os blocos
        for($i = 1; $i <= $request->howmanyblocks; $i++){
            $bloco = Bloco::find($i);
            $bloco->prefix = $request['bloco_'.$i];
            $bloco->save();
        }

        //Edita as configs
        $configs = Config::find(1);
        $configs->system_name = $request->system_name;
        $configs->visitor_car = $request->visitor_car;

        if ($request->car_time_minutes || $request->car_time_hours){
            if ($request->car_time_hours != null){
                $time = ($request->car_time_hours * 60) + $request->car_time_minutes;
                $configs->car_time = $time;
            } elseif($request->car_time_minutes) {
                $configs->car_time = $request->car_time_minutes;
            }
        }

        $configs->resident_registry = $request->resident_registry;
        $configs->save();

        return redirect()->route('admin.dashboard');
    }

    //Função que deleta um apartamento
    function delete($id){
        $ap = Apartamento::find($id);
        return view('admin.configuration.delete')->withAp($ap);
    }

    function destroy($id){
        $ap = Apartamento::find($id);
        $ap->delete();

        //Mensagem de Sucesso
        Session::flash('success', 'Apartamento editado com sucesso!');

        return redirect()->route('admin.config.index');
    }

    //Função que edita apartamento
    function apEdit($id){
        $blocos = Bloco::all();
        $ap = Apartamento::find($id);

        return view('admin.configuration.ap-edit')->withAp($ap)->withBlocos($blocos);
    }

    function apUpdate(Request $request, $id){
        //Salva os dados de edição no objeto Apartamento
        $apartamento = Apartamento::find($id);
        $apartamento->apartamento = $request->apartamento;
        $apartamento->bloco_id = $request->bloco_id;
        $apartamento->save();

        //Mensagem de Sucesso
        Session::flash('success', 'Apartamento editado com sucesso!');

        return redirect()->route('admin.config.index');
    }
}
