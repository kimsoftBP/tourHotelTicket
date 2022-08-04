<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubpagePhotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpage_photo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('photoid');
            $table->foreign('photoid')->references('id')->on('photo')->onDelete('cascade');
            $table->unsignedBigInteger('subpageid');
            $table->foreign('subpageid')->references('id')->on('subpage')->onDelete('cascade');

            $table->boolean('confirmed')->default(false);
            $table->unsignedBigInteger('confirm_by_userid')->nullable();

            $table->integer('photo_group');
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
        Schema::dropIfExists('subpage_photo');
    }
}
