<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bus_message', function (Blueprint $table) {
            $table->id();
            $table->string('to_mail')->nullable();
            $table->string('title')->nullable();
            $table->string('text');
            $table->unsignedBigInteger('to_userid')->nullable();
            //$table->foreign('to_userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('from_userid')->nullable();
            $table->foreign('from_userid')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('bus_companyid')->nullable();
            $table->foreign('bus_companyid')->references('id')->on('bus_company')->onDelete('cascade');
            $table->unsignedBigInteger('reply_by_bus_messageid')->nullable();
            $table->foreign('reply_by_bus_messageid')->references('id')->on('bus_message')->onDelete('cascade');

            $table->unsignedBigInteger('bus_typeid')->nullable();
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
        Schema::dropIfExists('bus_message');
    }
}
