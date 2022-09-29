<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusAvailableCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_available_calendar', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->year('year')->nullable();
            $table->unsignedInteger('month')->nullable();
            $table->unsignedInteger('day')->nullable();

            $table->unsignedBigInteger('bus_availableid')->nullable();
            $table->foreign('bus_availableid')->references('id')->on('bus_available')->onDelete('cascade');
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->foreign('bus_id')->references('id')->on('bus')->onDelete('cascade');
            $table->unsignedBigInteger('bus_available_typeid')->nullable();
            $table->foreign('bus_available_typeid')->references('id')->on('bus_available_type')->onDelete('cascade');
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
        Schema::dropIfExists('bus_available_calendar');
    }
}
