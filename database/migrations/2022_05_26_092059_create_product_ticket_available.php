<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTicketAvailable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ticket_avai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_ticket_available_piece_id');
            $table->foreign('product_ticket_available_piece_id')->references('id')->on('product_ticket_available_piece')->onDelete('cascade');
            $table->unsignedBigInteger('product_ticket_id');
            $table->foreign('product_ticket_id')->references('id')->on('product_ticket')->onDelete('cascade');
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
        Schema::dropIfExists('product_ticket_avai');
    }
}
