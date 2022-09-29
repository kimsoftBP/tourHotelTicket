<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('text',3000);

            $table->unsignedBigInteger('typeid')->nullable();
            $table->foreign('typeid')->references('id')->on('message_type')->onDelete('cascade');

            $table->unsignedBigInteger('replybyid')->nullable();
            $table->foreign('replybyid')->references('id')->on('message')->onDelete('cascade');

            $table->unsignedBigInteger('touserid')->nullable();
            $table->foreign('touserid')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('fromuserid')->nullable();
            $table->foreign('fromuserid')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('productid')->nullable();
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
        Schema::dropIfExists('message');
    }
}
