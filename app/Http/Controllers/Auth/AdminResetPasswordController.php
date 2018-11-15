<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Password;
use Auth;

class AdminResetPasswordController extends Controller
{
    ////Classe de reset de senha, da parte ForgotPassword

    use ResetsPasswords;

    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest:admin');
    }
    
    //Define qual guard será utilizada para o login e redirecionamento
    public function guard(){
        return Auth::guard('admin');
    }

    //Define o broker utilizado para o reset de senha
    public function broker(){
        return Password::broker('admins');
    }

    public function showResetForm(Request $request, $token = null){
        return view('auth.passwords.admin-reset')->with(['token' => $token, 'email' => $request->email]);
    }
}
