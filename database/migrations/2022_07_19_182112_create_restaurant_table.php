<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant', function (Blueprint $table) {
            $table->id();
            $table->string('city');
            $table->string('address');
            $table->string('name');
            $table->integer('max_person')->nullable();
            $table->unsignedBigInteger('countryid');
            $table->foreign('countryid')->references('id')->on('country')->onDelete('cascade');

            $table->unsignedBigInteger('restaurant_companyid');
            $table->foreign('restaurant_companyid')->references('id')->on('restaurant_company')->onDelete('cascade');
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
        Schema::dropIfExists('restaurant');
    }
}
