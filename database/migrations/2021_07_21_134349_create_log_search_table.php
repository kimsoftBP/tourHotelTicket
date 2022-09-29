<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_search', function (Blueprint $table) {
            $table->id();
            $table->string('search')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            //$table->unsignedBigInteger('categoryid')->nullable();
            //$table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('countryid')->nullable();
            $table->unsignedBigInteger('cityid')->nullable();
            $table->integer('minprice')->nullable();
            $table->integer('maxprice')->nullable();
            $table->string('grade')->nullable();
            $table->unsignedBigInteger('toursizeid')->nullable();
            $table->string('toursize')->nullable();
            $table->unsignedBigInteger('languageid')->nullable();
            $table->string('language')->nullable();
            $table->string('time')->nullable();
            $table->string('meetingtime')->nullable(); 
            $table->string('sessionid')->nullable();

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
        Schema::dropIfExists('log_search');
    }
}
