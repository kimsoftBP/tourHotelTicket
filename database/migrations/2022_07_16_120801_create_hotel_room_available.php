<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelRoomAvailable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_room_available', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('piece');
            $table->unsignedBigInteger('hotel_roomid');
            $table->foreign('hotel_roomid')->references('id')->on('hotel_room')->onDelete('cascade');
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
        Schema::dropIfExists('hotel_room_available');
    }
}
