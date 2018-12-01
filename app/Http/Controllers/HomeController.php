<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visita;
use App\Config;

//Controller de páginas de usuário logado, a alterar
class HomeController extends Controller
{
    //Função que permite apenas usuários logados acessem as funções, com exceção da função amin
    public function __construct()
    {
        $this->middleware('auth')->except('main');
    }

    //Função que retorna a página principal do usuário com visitas e veículos
    public function index()
    {
        $visitas = Visita::whereDate('created_at', date('Y-m-d'))->limit(5)->get();
        $carros = Visita::where('vehicle_parked', 1)->get();
        $configs = Config::all();
        return view('user.home')->withVisitas($visitas)->withCarros($carros)->withConfigs($configs);
    }

    public function main(){
        return redirect()->route('login');
    }
}
