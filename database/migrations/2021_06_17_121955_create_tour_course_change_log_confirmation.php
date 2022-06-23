<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourCourseChangeLogConfirmation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_course_change_log_confirmation', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('content')->nullable();

            $table->unsignedBigInteger('confirmbyuserid')->nullable();
            $table->foreign('confirmbyuserid')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('tour_course_change_log_confirmation');
    }
}
