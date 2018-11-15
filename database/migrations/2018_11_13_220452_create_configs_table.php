<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigsTable extends Migration
{
    //Migratio para criar tabela de configs
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('configured');
            $table->string('system_name');
            $table->boolean('visitor_car');
            $table->boolean('resident_registry');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
