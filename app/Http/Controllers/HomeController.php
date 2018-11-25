<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visita;

//Controller de páginas de usuário logado, a alterar
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('main');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitas = Visita::whereDate('created_at', date('Y-m-d'))->get();
        return view('user.home')->withVisitas($visitas);
    }

    public function main(){
        return view('welcome');
    }
}
