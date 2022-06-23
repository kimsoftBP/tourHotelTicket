<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductMeetingPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_meeting_photo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photoid');
            $table->foreign('photoid')->references('id')->on('photo')->onDelete('cascade');
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
        Schema::dropIfExists('product_meeting_photo');
    }
}
