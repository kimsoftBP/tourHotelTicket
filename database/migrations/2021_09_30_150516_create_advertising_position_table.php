<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisingPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising_position', function (Blueprint $table) {
            $table->id();
            $table->string('page');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('advertising_position')->insert([
                ['page'=>'index',
                'name'=>'area1'],
                ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertising_position');
    }
}
