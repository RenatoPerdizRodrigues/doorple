<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntradaMorador extends Model
{
    //Indicação que liga à tabela correta
    protected $table = 'entrada_moradores';

    //Relacionamento one to many com morador
    public function morador(){
        return $this->belongsTo('App\Morador');
    }

    //Relacionamento one to many com veiculo
    public function veiculo(){
        return $this->belongsTo('App\Veiculo');
    }
}
