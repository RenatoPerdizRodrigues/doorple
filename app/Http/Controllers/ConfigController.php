<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Apartamento;
use App\Morador;
use App\Bloco;
use Session;

//Controller das ações relacionadas a configurações do sistema
class ConfigController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('auth:admin');
        $this->middleware('checkConfig')->except('config1', 'config2', 'config3', 'config4', 'finishConfig');
    }
    
    //Retorna a view de todos os apartamentos
    public function index($bloco = null){
        //Retorna o primeiro bloco de apartamentos caso não tenha sido feita uma pesquisa
        $blocos = Bloco::all();
        if ($bloco == null){
            $prefix = Bloco::first();
            $bloco = Bloco::where('prefix', $prefix->prefix)->get();
            $apartamentos = Apartamento::with('moradores')->where('bloco_id', $bloco[0]->id)->get();
        } else {
            $bloco = Bloco::where('prefix', $bloco)->get();

            //Caso não tenha sido encontrado bloco, retornar para a função Index e passar a mensagem de fracasso
            if ($bloco->isEmpty()){
                Session::flash('success', 'Não foi encontrado um bloco com o valor selecionado.');

                return redirect()->route('admin.config.index');
            }

            //Caso tenha encontrado, retornar a view com o bloco selecionado
            $apartamentos = Apartamento::with('moradores')->where('bloco_id', $bloco[0]->id)->get();
        }
        //$apartamentos = Apartamento::with('moradores')->get();
        return view('admin.configuration.index')->withApartamentos($apartamentos)->withBlocos($blocos)->withBloco($bloco);
    }

    //Retorna o index com o bloco de apartamentos selecionado
    public function search(Request $request){
        return redirect()->route('admin.config.index', $request->bloco);
    }
    
    //Retorna a view inicial de configuração
    public function config1(){
        return view('admin.configuration.config1');
    }

    //Valida os dados da configuração inicial e retorna a view da próxima etapa de configuração
    public function config2(Request $request){
        //Valida os dados do formulário de configuração
        $this->validate($request, array(
            'system_name' => 'required|min:1|max:20',
            'visitor_car' => 'required|boolean',
            'resident_registry' => 'required|boolean'
        ));

        //Cálculo de tempo que o carro pode ficar no condomínio, em minutos
        if ($request->minutes || $request->car_time_hours){
            if ($request->car_time_hours != null){
                $horas = ($request->car_time_hours * 60);
            } 
            
            if($request->car_time_minutes  != null) {
                $minutos = $request->car_time_minutes;
            } 

            $time = $horas + $minutos; 
            
        } else {
            $time = 0;
        }

        //Redireciona para a configuração de apartamentos, embora os valores só vão vir a ser salvos em finishConfig()
        return view('admin.configuration.config2')->with('system_name', $request->system_name)->with('visitor_car', $request->visitor_car)->with('resident_registry', $request->resident_registry)->with('time', $time);
    }

    //Retorna a a continuação do formulário de configuração
    public function config3(Request $request){
        $total = $request->total;
        $blocos = $request->blocos;
        //Descobre a quantidade de apartamentos por bloco, arredondando para cima
        $pbloco = $total / $blocos;
        $pbloco = ceil($pbloco);

        //Retorna os valores da configuração inicial
        $system_name = $request->system_name;
        $visitor_car = $request->visitor_car;
        $resident_registry = $request->resident_registry;
        $time = $request->time;

        return view('admin.configuration.config3')->withTotal($total)->withBlocos($blocos)->withPblocos($pbloco)->with('system_name', $request->system_name)->with('visitor_car', $request->visitor_car)->with('resident_registry', $request->resident_registry)->with('time', $time);
    }

        //Retorna a visualização dos apartamentos
        public function config4(Request $request){

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

            //Retorna os valores da configuração inicial
            $system_name = $request->system_name;
            $visitor_car = $request->visitor_car;
            $resident_registry = $request->resident_registry;
            $time = $request->time;

            return view('admin.configuration.config4')->withTotal($total)->withBlocos($blocos)->withPblocos($pblocos)->withApartamentos($apartamentos)->with('system_name', $request->system_name)->with('visitor_car', $request->visitor_car)->with('resident_registry', $request->resident_registry)->with('time', $time);
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
        $config = new Config();
        $config->system_name = $request->system_name;
        $config->visitor_car = $request->visitor_car;
        $config->resident_registry = $request->resident_registry;
        $config->car_time = $request->time;
        $config->howmanyblocks = $request->blocos;
        $config->configured = 1;
        $config->save();

        //Mensagem de sucesso
        Session::flash('success', 'Configuração finalizada com sucesso!');
        
        return redirect()->route('admin.dashboard');
    }

    //Retorna a view para a criação de um apartamento individual
    public function create(){
        $blocos = Bloco::all();
        return view('admin.configuration.create')->withBlocos($blocos);
    }

    //Armazena apartamento individual referindo o bloco correto
    public function store(Request $request){

        //Verifica se o apartamento não é duplicado neste bloco
        $existente = Apartamento::where([['bloco_id', $request->bloco_id], ['apartamento', $request->apartamento]])->get();

        if ($existente->isEmpty()){
            //Salva os dados no objeto Apartamento
            $apartamento = new Apartamento();
            $apartamento->apartamento = $request->apartamento;
            $apartamento->bloco_id = $request->bloco_id;
            $apartamento->save();

            //Mensagem de sucesso
            Session::flash('success', 'Apartamento cadastrado com sucesso!');

            return redirect()->route('admin.config.index');
        }

        Session::flash('success', 'O Apartamento não pode ser cadastrado pois já existe no bloco selecionado.');
        return redirect()->route('admin.config.create');
    }

    //Função que retorna a edição de configurações do sistema e blocos
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
                $horas = ($request->car_time_hours * 60);
            } 
            
            if($request->car_time_minutes  != null) {
                $minutos = $request->car_time_minutes;
            }
    
            $configs->car_time = $horas + $minutos; 
        }

        $configs->resident_registry = $request->resident_registry;
        $configs->save();

        Session::flash('success', 'Configurações atualizadas com sucesso');

        return redirect()->route('admin.config.edit');
    }

    //Função que deleta um apartamento vazio
    function delete($id){
        $ap = Apartamento::where('id', $id)->first();

        if ($ap->moradores->isEmpty()){
            return view('admin.configuration.delete')->withAp($ap);    
        }

        Session::flash('success', 'Não é possível deletar um apartamento que possua moradores');
        return redirect()->route('admin.config.index');
    }

    function destroy($id){
        $ap = Apartamento::find($id);

        if ($ap->moradores->isEmpty()){
            $ap->delete();

            //Mensagem de Sucesso
            Session::flash('success', 'Apartamento deletado com sucesso!');

            return redirect()->route('admin.config.index');
        }

        Session::flash('success', 'Não é possível deletar um apartamento que possua moradores');
        return redirect()->route('admin.config.index');         
        
    }

    //Função que edita apartamento
    function apEdit($id){
        $blocos = Bloco::all();
        $ap = Apartamento::where('id', $id)->first();

        return view('admin.configuration.ap-edit')->withAp($ap)->withBlocos($blocos);
    }

    function apUpdate(Request $request, $id){
        //Verifica se o apartamento não é duplicado neste bloco
        $existente = Apartamento::where([['bloco_id', $request->bloco_id], ['apartamento', $request->apartamento]])->get();
        $original = Apartamento::where('id', $id)->first();

        if ($original->bloco_id == $request->bloco_id && $original->apartamento == $request->apartamento){
            //Mensagem de sucesso
            Session::flash('success', 'Apartamento editado com sucesso!');

            return redirect()->route('admin.config.index');
        }

        if ($existente->isEmpty()){
            //Salva os dados de edição no objeto Apartamento
            $apartamento = Apartamento::find($id);
            $apartamento->apartamento = $request->apartamento;
            $apartamento->bloco_id = $request->bloco_id;
            $apartamento->save();

            //Mensagem de sucesso
            Session::flash('success', 'Apartamento editado com sucesso!');

            return redirect()->route('admin.config.index');
        }

        Session::flash('success', 'O Apartamento não pode ser editado pois este apartamento já existe no bloco selecionado.');
        return redirect()->route('admin.config.ap-edit', $id);
    }
}
