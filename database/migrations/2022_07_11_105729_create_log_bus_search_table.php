<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogBusSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_bus_search', function (Blueprint $table) {
            $table->id();
            $table->string('sessionid');
            $table->string('ip');
            $table->integer('persons')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();

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
        Schema::dropIfExists('log_bus_search');
    }
}
