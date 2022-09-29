<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductChangeLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_change_log_confirmation', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('onelinesummary',500)->nullable();
            $table->string('introduction',3000)->nullable();
            $table->string('meetingplacename')->nullable();
            $table->string('meetingplacecoordinate')->nullable();

            $table->string('priceincluded',2000)->nullable();
            $table->string('notincluded',2000)->nullable();
            $table->string('essentialguidance',2000)->nullable();
            
            $table->unsignedBigInteger('confirmbyuserid')->nullable();
            $table->foreign('confirmbyuserid')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('productid');
            $table->foreign('productid')->references('id')->on('product')->onDelete('cascade');
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
        Schema::dropIfExists('product_change_log_confirmation');
    }
}
