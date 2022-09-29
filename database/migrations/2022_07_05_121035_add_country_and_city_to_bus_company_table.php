<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryAndCityToBusCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_company', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('countryid')->nullable();
            $table->foreign('countryid')->references('id')->on('country');
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
        Schema::table('bus_company', function (Blueprint $table) {
            //
            $table->dropForeign(['countryid']);
            $table->dropColumn(['countryid','city']);
        });
    }
}
