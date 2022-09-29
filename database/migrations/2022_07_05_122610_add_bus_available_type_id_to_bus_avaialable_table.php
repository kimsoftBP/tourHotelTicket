<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBusAvailableTypeIdToBusAvaialableTable extends Migration
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
            $table->unsignedBigInteger('bus_available_typeid')->nullable();
            $table->foreign('bus_available_typeid')->references('id')->on('bus_available_type')->onDelete('cascade');
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
         //   $table->dropForeign(['bus_available_typeid']);
            $table->dropColumn(['bus_available_typeid']);
        });
    }
}
