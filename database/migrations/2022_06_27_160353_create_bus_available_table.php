<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusAvailableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_available', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('busid');
            $table->foreign('busid')->references('id')->on('bus')->onDelete('cascade');
            $table->date('date');
            $table->time('from_time')->nullable();//not null if not whole day available
            $table->time('to_time')->nullable();//not null if not whole day available
            $table->date('to_date');
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
        Schema::dropIfExists('bus_available');
    }
}
