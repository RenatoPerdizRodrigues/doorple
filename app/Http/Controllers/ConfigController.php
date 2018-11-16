<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Apartamento;
use App\Morador;

class ConfigController extends Controller
{
    //Retorna a view do formulário de configuração inicial
    public function index(){
        $apartamentos = Apartamento::with('moradores')->get();
        return view('admin.configuration.index')->withApartamentos($apartamentos);
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
        $config->resident_registry = $request->resident_registry;
        $config->save();

        //Redireciona para a configuração de apartamentos
        return redirect()->route('admin.config.ap');
    }

    //Retorna a view do formulário de configuração de apartamentos
    public function apIndex(){
        return view('admin.configuration.config-ap');
    }

    //Retorna a view do formulário de configuração de apartamento, com o get passado
    public function apDetail(){
        return view('admin.configuration.config-ap-2');
    }

        //Retorna a visualização dos apartamentos
        public function apDetail2(){
            return view('admin.configuration.config-ap-3');
        }

    //Valida dados de configuração final
    public function finishConfig(Request $request){
        //Array dos apartamentos a serem inseridos
        $apartamentos = array();
        //Um for que rode para cada bloco
        for ($i = 1; $i <= $request->howmanyblocks; $i++){
            //Um for para cada apartamento a ser inserido, com o prefixo correto
            for ($i2 = 1; $i2 <= $request->howmanyblock; $i2++){
                //insere prefix_$i-ap_$i2;
                $apartamento = $request['prefix_'.$i]."-".$request['ap_'.$i2];
                array_push($apartamentos, $apartamento);
            }
        }
        
        foreach($apartamentos as $apartamento){
            Apartamento::create([
                'apartamento' => $apartamento
            ]);
        }

        //Método que salva o booleano de configuração como true
            $config = Config::all();
            $config[0]->configured = 1;
            $config[0]->save();
        
        return redirect()->route('admin.dashboard');
    }

    //Função que retorna a edição de configuração e apartamentos
    public function edit(){
        $apartamentos = Apartamento::all();
        $configs = Config::all();
        return view('admin.configuration.edit')->withApartamentos($apartamentos)->withConfigs($configs);
    }
}
