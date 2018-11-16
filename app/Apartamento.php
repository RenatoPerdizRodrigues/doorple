<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Modelo de Apartamentos, da tabela apartamentos
class Apartamento extends Model
{
    //Função de relacionamento one to many com morador
    public function moradores(){
        return $this->hasMany('App\Morador');
    }

    //Permite a criação de apartamentos em massa
    protected $fillable = [
        'apartamento',
    ];

}
