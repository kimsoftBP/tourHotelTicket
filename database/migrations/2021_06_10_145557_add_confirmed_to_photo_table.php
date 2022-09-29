<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmedToPhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photo', function (Blueprint $table) {
            $table->boolean('checkadmin')->default(false);
            $table->unsignedBigInteger('confirmbyuserid')->nullable();
            $table->foreign('confirmbyuserid')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photo', function (Blueprint $table) {
            $table->dropForeign('photo_confirmbyuserid_foreign');
           $table->dropColumn(['checkadmin','confirmbyuserid']);
        });
    }
}
