<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryAndCityToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //

            $table->unsignedBigInteger('countryid')->nullable();
            $table->foreign('countryid')->references('id')->on('country');
            //$table->foreign('reservation_payid')->references('id')->on('reservation_pay')->onDelete('cascade');
            $table->unsignedBigInteger('cityid')->nullable();
            $table->foreign('cityid')->references('id')->on('city');

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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['countryid','cityid','city']);
        });
    }
}
