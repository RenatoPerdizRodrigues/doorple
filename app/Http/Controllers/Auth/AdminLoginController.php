<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdminLoginController extends Controller
{
    //Garante que apenas usuários não logados possam usar as funções da classe 
    public function __construct(){
        $this->middleware('guest:admin')->except('adminLogout');
    }

    //Mostra formulário de login de administradores
    public function showLoginForm(){
        if(Auth::guard('web')->check()){
            return redirect()->route('user.dashboard');
        }
        return view('auth.admin.login');
    }

    //Realiza o login
    public function login(Request $request){
        //Valida login
        $this->validate($request, array(
            'email' => 'required|email',
            'password' => 'required|min:6'
        ));

        //Tenta logar usuário pela guard do admin
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            //Caso bem sucedido
            return redirect()->intended(route('admin.dashboard'));
        } else {
            //Caso não tenha sido autenticado, retorna com o email do formulário preenchido
            return redirect()->back()->withInput($request->only('email', 'remember'));
        }
    }

    //Realiza o logout
    public function adminLogout(){
        Auth::guard('admin')->logout();
        return redirect('/');
    }

}
