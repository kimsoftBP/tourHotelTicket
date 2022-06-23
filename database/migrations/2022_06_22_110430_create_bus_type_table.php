<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_type', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('name')->nullable();
            $table->integer('seat')->nullable();
            $table->integer('luggage_places')->nullable();
      //      $table->date('yearofmanufacture')->nullable();
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
        Schema::dropIfExists('bus_type');
    }
}
