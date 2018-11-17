<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateConfigsAddHowmanyblocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function ($table) {
            $table->integer('howmanyblocks')->unsigned()->nullable()->after('system_name');
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs', function ($table) {
            $table->dropColumn('howmanyblocks');
        });   
    }
}
