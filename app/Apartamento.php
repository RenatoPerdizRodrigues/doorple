<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartamento extends Model
{
    //Permite a criação de apartamentos em massa
    protected $fillable = [
        'apartamento',
    ];

}
