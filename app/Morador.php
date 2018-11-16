<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Morador extends Model
{  
    //Indicação da tabela correta
    protected $table = 'moradores';

    //Relacionamento one to many com apartamentos
    public function apartamento(){
        return $this->belongsTo('App\Apartamento');
    }

    //Relacionamento one to many com veiculos
    public function veiculos(){
        return $this->hasMany('App\Veiculo');
    }
}
