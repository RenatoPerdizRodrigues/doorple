<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'configured', 'system_name', 'visitor_car', 'resident_registry'
    ];
}
