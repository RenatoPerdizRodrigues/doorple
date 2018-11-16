<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVeiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('veiculos_morador', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('license_plate');
            $table->string('color');
            $table->integer('morador_id')->unsigned()->nullable();
            $table->foreign('morador_id')->references('id')->on('moradores');
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
        Schema::dropIfExists('veiculos_morador');
    }
}
