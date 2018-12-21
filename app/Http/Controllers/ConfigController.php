<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Apartamento;
use App\Morador;
use App\Bloco;
use App\Visita;
use Session;

//Controller das ações relacionadas a configurações do sistema
class ConfigController extends Controller
{
    //Construct que permite acesso apenas a administradores logados
    public function __construct(){
        $this->middleware('multiView')->except('config1', 'config1Save', 'config2', 'config2Save', 'config3', 'config3Post', 'config3Save', 'create', 'store', 'edit', 'update', 'delete', 'destroy', 'apEdit', 'apUpdate');
        $this->middleware('auth:admin')->except('search', 'index');;
        $this->middleware('checkConfig')->except('config1', 'config1Save', 'config2', 'config2Save', 'config3', 'config3Post', 'config3Save');
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
                Session::flash('warning', 'Não foi encontrado um bloco com o valor selecionado.');

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
    
    //Retorna a view inicial de configuração, checando se o usuário já inicializou e não terminou
    public function config1(){
        $configs = Config::where('id', 1)->first();
        $horas = null;
        $minutos = null;

        if($configs != null){
            //Retorna as horas e minutos permitidas pelo carro
            $decimal = $configs->car_time / 60;
            $horas = floor($decimal);
            $resto = $decimal - $horas;
            $minutos = $resto * 60;
        }

        return view('admin.configuration.config1')->withConfigs($configs)->withHoras($horas)->withMinutos($minutos);
    }

    //Valida os dados da configuração inicial e redireciona para a próxima etapa da configuração
    //esse seria o save.config1
    public function config1Save(Request $request){
        //Valida os dados do formulário de configuração
        $this->validate($request, array(
            'system_name' => 'required|min:1|max:20',
            'visitor_car' => 'required|boolean',
            'resident_registry' => 'required|boolean',
            'car_time_hours' => 'nullable|integer',
            'car_time_minutes' => 'nullable|integer'
        ));

        if($request->visitor_car == 1){
            if($request->car_time_hours == null && $request->car_time_minutes == null){
                Session::flash('warning', 'Caso seja permitida a entrada de veículos no condomínio, favor selecione o tempo de estadia permitido!');
                return back()->withInput();
            }
        }

        //Cálculo de tempo que o carro pode ficar no condomínio, em minutos
        if ($request->minutes || $request->car_time_hours){
            if ($request->car_time_hours != null){
                $horas = ($request->car_time_hours * 60);
            } else {
                $horas = 0;
            }
            
            if($request->car_time_minutes  != null) {
                $minutos = $request->car_time_minutes;
            }  else {
                $minutos = 0;
            }

            $time = $horas + $minutos; 
            
        } else {
            $time = 0;
        }

        //Insere os dados iniciais da configuração no banco de dados
        $configs = Config::find(1);
        if ($configs == null){
            $configs = new Config();
            $configs->id = 1;
        }

        $configs->system_name = $request->system_name;
        $configs->visitor_car = $request->visitor_car;
        $configs->car_time = $time;
        $configs->resident_registry = $request->resident_registry;
        $configs->total = 0;
        $configs->configured = 0;
        $configs->save();

        //Redireciona para a configuração de apartamentos
        return redirect()->route('admin.config2');
    }

    //Retorna a view do segundo formulário de configuração
    public function config2(){
        $configs = Config::find(1);
        if ($configs == null){
            Session::flash("Por favor preencha corretamente as informações do sistema.");
            return redirect()->route('admin.config1');
        }

        return view('admin.configuration.config2')->withConfigs($configs);
    }

    //Salva o segundo formulário de configuração
    public function config2Save(Request $request){        
         //Valida os dados do formulário de configuração
         $this->validate($request, array(
            'total' => 'required|numeric|max:900',
            'blocos' => 'required|numeric|max:90',
        ));

        //Insere os dados da segunda configuração no banco de dados
        $configs = Config::find(1);
        if ($configs == null){
            Session::flash("Por favor preencha corretamente as informações do sistema.");
            return redirect()->route('admin.config1');
        }
        
        $configs->total = $request->total;
        $configs->howmanyblocks = $request->blocos;
        $configs->save();

        return redirect()->route('admin.config3');
    }

    //Retorna a visualização do primeiro bloco para preenchimento
    public function config3(){
        $configs = Config::find(1);
        if ($configs == null){
            Session::flash("Por favor preencha corretamente as informações do sistema.");
            return redirect()->route('admin.config1');
        }

        //Descobre a quantidade de apartamentos por bloco, arredondando para cima
        $pbloco = $configs->total / $configs->howmanyblocks;
        $pbloco = ceil($pbloco);

        return view('admin.configuration.config3')->withTotal($configs->total)->withBlocos($configs->howmanyblocks)->withPblocos($pbloco);
    }

        //Retorna a visualização de todos os blocos e apartamentos para modelagem
        public function config3Post(Request $request){
            //Valida o número máximo de blocos permitidos
            $this->validate($request, array(
                'blocos' => 'nullable|integer|max:90',
                'blocosold' => 'nullable|integer|max:90'
            ));

            //Verifica se os apartamentos não ultrapassam o valor máximo de 900
            if ($request->blocos != null){
                if ($request->blocos * count($request->ap) > 900){
                    Session::flash("warning", 'O número total de apartamentos do condomínio não pode ultrapassar 900.');
                    return redirect()->back()->withInput();
                }
            } else {
                if ($request->blocosold * count($request->ap) > 900){
                    Session::flash("warning", 'O número total de apartamentos do condomínio não pode ultrapassar 900.');
                    return redirect()->back()->withInput();
                }                
            }

            //Verifica se no mínimo um apartamento preenchido não é nulo
            $notnull = 0;
            foreach($request->ap as $ap){
                if($ap != null){
                    $notnull++;
                }
            }

            if($notnull == 0){
                Session::flash('warning', 'Preencha pelo menos um apartamento para o bloco.');
                return redirect()->back();
            }

            $total = $request->total;
            if($request->blocos == null){
                $blocos = $request->blocosold;
            } else {
                $blocos = $request->blocos;    
            }            
            $pblocos = $request->pblocos;

            //Coloca apenas os apartamentos preenchidos
            $apartamentos = array();
            foreach($request->ap as $ap){
                if($ap != ""){
                    array_push($apartamentos, $ap);
                }
            }

            return view('admin.configuration.config4')->withTotal($total)->withBlocos($blocos)->withPblocos($pblocos)->withApartamentos($apartamentos);
        }

    //Valida dados de configuração final
    public function config3Save(Request $request){
        //Contagem do total de apartamentos para verificar se não ultrapassa 900
        $aptotal = 0;
        for($i = 1; $i <= $request->blocos; $i++){
            foreach ($request['apartamento_'.$i] as $apartamento){
                $aptotal++;
            }
        }

        if($aptotal > 900){
            Session::flash("warning", 'O número total de apartamentos do condomínio não pode ultrapassar 900.');
            return redirect()->back()->withInput();
        }

        //Insere todos os blocos e seus respectivos valores. Caso não tenha sido colocado o nome, insere como 'Bloco x'
        for($i = 1; $i <= $request->blocos; $i++){

            if($request['prefix'.$i] == null){
                $bloco = $i;
            } else {
                $bloco = $request['prefix'.$i];
            }

            $bloco = new Bloco([
                'prefix' => $bloco
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

        //Método que salva o booleano de configuração como true e altera o total de apartamentos e blocos de acordo
        $configs = Config::find(1);
        if ($configs == null){
            Session::flash("Por favor preencha corretamente as informações do sistema.");
            return redirect()->route('admin.config1');
        }
        $configs->howmanyblocks = $request->blocos;
        $configs->total = $aptotal;
        $configs->configured = 1;
        $configs->save();

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

            //Acrescenta o apartamento cadastrado no total
            $configs = Config::where('id', 1)->first();
            $configs->total += 1;
            $configs->save();

            //Mensagem de sucesso
            Session::flash('success', 'Apartamento cadastrado com sucesso!');

            return redirect()->route('admin.config.index');
        }

        Session::flash('warning', 'O Apartamento não pode ser cadastrado pois já existe no bloco selecionado.');
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

        if ($request->visitor_car == 0){
            Visita::where('vehicle_parked', 1)->update([
                'vehicle_parked' => 0,
            ]);
        }
         
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
    public function delete($id){
        $ap = Apartamento::where('id', $id)->first();

        if ($ap->moradores->isEmpty()){
            return view('admin.configuration.delete')->withAp($ap);    
        }

        Session::flash('warning', 'Não é possível deletar um apartamento que possua moradores');
        return redirect()->route('admin.config.index');
    }

    //Deleta um apartamento vazio
    public function destroy($id){
        $ap = Apartamento::find($id);

        if ($ap->moradores->isEmpty()){
            $ap->delete();

            //Retira o apartamento cadastrado do total
            $configs = Config::where('id', 1)->first();
            $configs->total -= 1;
            $configs->save();

            //Mensagem de Sucesso
            Session::flash('success', 'Apartamento deletado com sucesso!');

            return redirect()->route('admin.config.index');
        }

        Session::flash('warning', 'Não é possível deletar um apartamento que possua moradores');
        return redirect()->route('admin.config.index');         
        
    }

    //Função que edita apartamento
    public function apEdit($id){
        $blocos = Bloco::all();
        $ap = Apartamento::where('id', $id)->first();

        return view('admin.configuration.ap-edit')->withAp($ap)->withBlocos($blocos);
    }

    public function apUpdate(Request $request, $id){
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

        Session::flash('warning', 'O Apartamento não pode ser editado pois este apartamento já existe no bloco selecionado.');
        return redirect()->route('admin.config.ap-edit', $id);
    }
}
