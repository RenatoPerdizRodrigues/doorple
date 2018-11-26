<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    //Relacionamento one to many com visitas
    public function visitas(){
        return $this->hasMany('App\Visita');
    }
}
