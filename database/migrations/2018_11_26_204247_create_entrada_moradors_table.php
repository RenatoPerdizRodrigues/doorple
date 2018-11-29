<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradaMoradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_moradores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('morador_id')->unsigned();
            $table->foreign('morador_id')->references('id')->on('moradores');
            $table->integer('veiculo_id')->unsigned()->nullable();
            $table->foreign('veiculo_id')->references('id')->on('veiculos_morador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada_moradores');
    }
}
