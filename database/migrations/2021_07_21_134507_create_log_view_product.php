<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogViewProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_view_product', function (Blueprint $table) {
            $table->id();
            $table->string('sessionid')->nullable();
            $table->unsignedBigInteger('productid');
            $table->unsignedBigInteger('countryid');
            $table->unsignedBigInteger('cityid')->nullable();
            $table->unsignedBigInteger('categoryid');
            $table->unsignedBigInteger('toursizeid');
            $table->time('meetingtime');
            $table->integer('totalrequiredday')->nullable();
            $table->integer('totalrequiredhour')->nullable();
            $table->integer('totalrequiredminute')->nullable();
            $table->unsignedBigInteger('vehicleid')->nullable();
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
        Schema::dropIfExists('log_view_product');
    }
}
