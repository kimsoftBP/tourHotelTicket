<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bustypeid');
            $table->foreign('bustypeid')->references('id')->on('bus_type')->onDelete('cascade');
            $table->unsignedBigInteger('bus_companyid');
            $table->foreign('bus_companyid')->references('id')->on('bus_company')->onDelete('cascade');

            $table->integer('piece')->nullable();
            $table->year('year')->nullable();
            $table->string('license_plate')->nullable();
            $table->string('basecity');

            $table->integer('passenger_seats')->nullable();
            $table->integer('luggage_places')->nullable();

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
        Schema::dropIfExists('bus');
    }
}
