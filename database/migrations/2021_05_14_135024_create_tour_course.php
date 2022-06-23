<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourCourse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_course', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('content',3000);
            $table->integer('hour');
            $table->integer('minute');
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
        Schema::dropIfExists('tour_course');
    }
}
