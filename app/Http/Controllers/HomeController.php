<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visita;
use App\Config;
use DateTime;

//Controller de páginas de usuário logado, e que inicializa a função de timer de tempo restante de veículo estacionado
class HomeController extends Controller
{
    //Função que permite apenas usuários logados acessem as funções, com exceção da função amin
    public function __construct()
    {
        $this->middleware('auth')->except('main');
        $this->middleware('checkConfig');
    }

    //Função que retorna a página principal do usuário com visitas e veículos, e array para timer de contagem
    public function index()
    {
        $visitas = Visita::whereDate('created_at', date('Y-m-d'))->orderBy('created_at', 'desc')->limit(5)->get();
        $carros = Visita::where('vehicle_parked', 1)->orderBy('created_at', 'asc')->paginate(10);
        $configs = Config::all();

        //Array de tempo restante de cada carro
        $data_entrada = array();

        foreach($carros as $carro){
            //Pega a hora de entrada do veículo no condomínio
            $horaEntrada = new DateTime($carro->created_at);
            $horario_saida = $horaEntrada->add(date_interval_create_from_date_string($configs[0]->car_time . ' minutes'));

            //Converte a timestamp para UNIX para passar para o JS
            $horario_saida = $horario_saida->format('Y-m-d H:i:s');
            $horario_saida = strtotime($horario_saida);

            //Coloca a timestamp do horário máximo de saída no array
            array_push($data_entrada, $horario_saida);

        }

        return view('user.home')->withVisitas($visitas)->withCarros($carros)->withConfigs($configs)->with('data_entrada', $data_entrada);
    }

    public function main(){
        return redirect()->route('login');
    }
}
