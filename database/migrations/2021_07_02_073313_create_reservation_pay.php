<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_pay', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('reservationid')->nullable();
            $table->foreign('reservationid')->references('id')->on('reservation')->onDelete('cascade');

            $table->unsignedBigInteger('paymethodid')->nullable();
            $table->foreign('paymethodid')->references('id')->on('paymethod')->onDelete('cascade');

            $table->string('checkoutid')->nullable();
            $table->string('checkoutref')->nullable();
            $table->string('status');

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
        Schema::dropIfExists('reservation_pay');
    }
}
