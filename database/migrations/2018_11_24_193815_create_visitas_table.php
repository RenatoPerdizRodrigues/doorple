<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitante_id')->unsigned();
            $table->foreign('visitante_id')->references('id')->on('visitantes');
            $table->integer('apartamento_id')->unsigned();
            $table->foreign('apartamento_id')->references('id')->on('apartamentos');
            $table->integer('bloco_id')->unsigned();
            $table->foreign('bloco_id')->references('id')->on('blocos');
            $table->string('vehicle_license_plate')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->boolean('vehicle_parked')->nullable();
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
        Schema::dropIfExists('visitas');
    }
}
