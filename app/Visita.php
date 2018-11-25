<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    //hasOne apartamento e bloco, que belongsTo visita

    //Relacionamento one to many com visitante
    public function visitante(){
        return $this->belongsTo('App\Visitante');
    }

    //Relacionamento one to many com apartamento
    public function apartamento(){
        return $this->belongsTo('App\Apartamento');
    }

    //Relacionamento one to many com bloco
    public function bloco(){
        return $this->belongsTo('App\Bloco');
    }

}
