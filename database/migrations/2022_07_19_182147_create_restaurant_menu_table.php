<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_menu', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('text');
            $table->double('price',10,2);
            $table->unsignedBigInteger('currencyid');
            $table->foreign('currencyid')->references('id')->on('currency')->onDelete('cascade');

            $table->unsignedBigInteger('restaurantid');
            $table->foreign('restaurantid')->references('id')->on('restaurant')->onDelete('cascade');
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
        Schema::dropIfExists('restaurant_menu');
    }
}
