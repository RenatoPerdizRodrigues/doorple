<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Password;
use Auth;


class AdminForgotPasswordController extends Controller
{
    //Classe de reset de senha, da parte ForgotPassword

    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    protected function broker(){
        return Password::broker('admins');
    }

    public function showLinkRequestForm(){
        return view('auth.passwords.admin-email');
    }
}
