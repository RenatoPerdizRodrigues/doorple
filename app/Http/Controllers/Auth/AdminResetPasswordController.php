<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Password;
use Auth;

class AdminResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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