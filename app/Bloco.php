<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    //Indicação da tabela correta
    protected $table = 'blocos';

    //Relação one to many com apartamentos;
    public function apartamentos(){
        return $this->hasMany('App\Apartamento');
    }

        //Relação one to many com apartamentos;
        public function moradores(){
            return $this->hasMany('App\Morador');
        }
}
