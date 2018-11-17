<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartamentosTable extends Migration
{
    //Migration que cria a tabela de apartamentos
    public function up()
    {
        Schema::create('apartamentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apartamento');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apartamentos');
        
        Schema::dropIfExists('blocos');
    }
}
