<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCityRemoveToBusAvailableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_available', function (Blueprint $table) {
            //
            $table->boolean('remove')->default(false);
            $table->date('remove_date')->nullable();
            $table->string('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_available', function (Blueprint $table) {
            //
            $table->dropColumn(['remove','remove_date','city']);
        });
    }
}
