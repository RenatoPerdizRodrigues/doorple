<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    //Indicação da tabela correta
    protected $table = 'veiculos_morador';

    //Relacionamento one to many com veiculos
    public function morador(){
        return $this->belongsTo('App\Morador');
    }
}
