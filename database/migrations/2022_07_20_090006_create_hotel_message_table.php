<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_message', function (Blueprint $table) {
            $table->id();
            $table->string('to_mail')->nullable();
            $table->string('title')->nullable();
            $table->string('text');
            $table->unsignedBigInteger('to_userid')->nullable();
            $table->unsignedBigInteger('from_userid')->nullable();
            $table->foreign('from_userid')->references('id')->on('users')->onDelete('cascade')
            $table->unsignedBigInteger('hotel_companyid')->nullable();
            $table->foreign('hotel_companyid')->references('id')->on('hotel_company')->onDelete('cascade');

            $table->unsignedBigInteger('reply_by_hotel_messageid')->nullable();
            $table->foreign('reply_by_hotel_messageid')->references('id')->on('hotel_message')->onDelete('cascade');

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
        Schema::dropIfExists('hotel_message');
    }
}
