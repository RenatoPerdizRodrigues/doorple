<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\AdminResetPasswordNotification;

//Modelo de Administradores, da tabela admins
class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    //Função que sobescreve o envio do email para reset de senha de admins
    public function sendPasswordResetNotification($token){
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
