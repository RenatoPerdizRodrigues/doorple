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

    //Relação one to many com blocos;
    public function bloco(){
        return $this->belongsTo('App\Bloco');
    }

    //Relacionamento one to many com visitas
    public function visitas(){
        return $this->hasMany('App\Visita');
    }

    //Permite a criação de apartamentos em massa
    protected $fillable = [
        'apartamento', 'bloco_id',
    ];

}
