<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_company', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('postcode');
            $table->string('address');
            $table->string('tax_number');
            $table->string('city');
            $table->unsignedBigInteger('countryid');
            $table->foreign('countryid')->references('id')->on('country');
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
        Schema::dropIfExists('hotel_company');
    }
}
