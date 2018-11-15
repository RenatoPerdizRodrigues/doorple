<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Modelo de Apartamentos, da tabela apartamentos
class Apartamento extends Model
{
    //Permite a criação de apartamentos em massa
    protected $fillable = [
        'apartamento',
    ];

}
