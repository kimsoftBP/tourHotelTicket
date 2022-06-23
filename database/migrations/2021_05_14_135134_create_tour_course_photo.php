<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourCoursePhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_course_photo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photoid');
            $table->foreign('photoid')->references('id')->on('photo')->onDelete('cascade');
            $table->unsignedBigInteger('tour_courseid');
            $table->foreign('tour_courseid')->references('id')->on('tour_course')->onDelete('cascade');
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
        Schema::dropIfExists('tour_course_photo');
    }
}
