<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_room', function (Blueprint $table) {
            $table->id();
            $table->integer('standard_people')->nullable();
            $table->integer('maximum_people')->nullable();
            $table->string('name')->nullable();
            $table->string('text')->nullable();
            $table->integer('piece');
            $table->unsignedBigInteger('hotelid');
            $table->foreign('hotelid')->references('id')->on('hotel')->onDelete('cascade');
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
        Schema::dropIfExists('hotel_room');
    }
}
