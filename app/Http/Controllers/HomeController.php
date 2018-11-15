<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('user.home');
    }

    public function main(){
        return view('welcome');
    }
}
