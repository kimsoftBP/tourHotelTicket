<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaylog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paylog', function (Blueprint $table) {
            $table->id();

            $table->string('event')->nullable();
            $table->string('text')->nullable();
            $table->string('status');
            $table->string('checkoutid')->nullable();
            $table->string('checkoutRef')->nullable();


            $table->unsignedBigInteger('reservation_payid')->nullable();
            $table->foreign('reservation_payid')->references('id')->on('reservation_pay')->onDelete('cascade');

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
        Schema::dropIfExists('paylog');
    }
}
