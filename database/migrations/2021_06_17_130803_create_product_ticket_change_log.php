<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTicketChangeLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ticket_change_log', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('shortdesc')->nullable();

            $table->unsignedBigInteger('confirmbyuserid')->nullable();
            $table->foreign('confirmbyuserid')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('product_ticketid');
            $table->foreign('product_ticketid')->references('id')->on('product_ticket')->onDelete('cascade');
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
        Schema::dropIfExists('product_ticket_change_log');
    }
}
