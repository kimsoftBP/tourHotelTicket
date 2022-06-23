<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_ticket', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('shortdesc');
            $table->integer('price');
            $table->boolean('eticket');

            $table->unsignedBigInteger('currencyid');
            $table->foreign('currencyid')->references('id')->on('currency');
            $table->unsignedBigInteger('ticketid');

            $table->unsignedBigInteger('reservationid');
            $table->foreign('reservationid')->references('id')->on('reservation')->onDelete('cascade');;
            $table->integer('piece');
            $table->integer('sumprice')->nullable();

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
        Schema::dropIfExists('reservation_ticket');
    }
}
