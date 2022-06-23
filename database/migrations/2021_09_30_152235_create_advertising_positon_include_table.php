<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisingPositonIncludeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_position_include', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advertisingid');
            $table->foreign('advertisingid')->references('id')->on('advertising')->onDelete('cascade');
            $table->unsignedBigInteger('advertisingpositionid');
            $table->foreign('advertisingpositionid')->references('id')->on('advertising_position')->onDelete('cascade');
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
        Schema::dropIfExists('advertising_position_include');
    }
}
