<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            $table->string('url')->nullable();
            $table->string('routename')->nullable();
            $table->string('sessionid')->nullable();
            $table->string('ip')->nullable();
            $table->string('ipv6')->nullable();
            $table->string('country')->nullable();
            $table->string('countrycode')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('referer')->nullable();             
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
        Schema::dropIfExists('log');
    }
}
