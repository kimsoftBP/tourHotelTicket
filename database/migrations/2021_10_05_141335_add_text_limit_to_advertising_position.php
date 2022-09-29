<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextLimitToAdvertisingPosition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advertising_position', function (Blueprint $table) {
            //
            $table->integer('text_max_rows')->nullable();
            $table->integer('text_max_colums')->nullable();
            $table->integer('image_max_width')->nullable();
            $table->integer('image_max_height')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advertising_position', function (Blueprint $table) {
            //
            $table->dropColumn(['text_max_rows','text_max_colums','image_max_height','image_max_width']);
        });
    }
}
