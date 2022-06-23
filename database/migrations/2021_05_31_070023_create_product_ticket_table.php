<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_ticket', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('shortdesc')->nullable();
            $table->integer('price');
            $table->date('expire')->nullable();
            $table->boolean('eticket')->nullable()->default(false);

            $table->unsignedBigInteger('currencyid');
            $table->foreign('currencyid')->references('id')->on('currency')->onDelete('cascade');

            $table->unsignedBigInteger('productid');
            $table->foreign('productid')->references('id')->on('product')->onDelete('cascade');
            
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
        Schema::dropIfExists('product_ticket');
    }
}
