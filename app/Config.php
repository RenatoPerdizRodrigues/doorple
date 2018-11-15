<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//Modelo de Configurações, da tabela configs
class Config extends Model
{
    //Permite a criação em massa de configs, para o seeder
    protected $fillable = [
        'configured', 'system_name', 'visitor_car', 'resident_registry'
    ];
}
