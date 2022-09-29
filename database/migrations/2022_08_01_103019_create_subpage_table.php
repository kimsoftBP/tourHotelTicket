<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubpageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subpage', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('text')->nullable();
            $table->string('text_area2')->nullable();
            $table->string('text_area3')->nullable();
            $table->json('data')->nullable();

            $table->boolean('confirmed')->default(false);
            $table->unsignedBigInteger('confirm_by_userid')->nullable();

            /*one time use only one company id .. ~same subpage structure usage each company
            */
            $table->unsignedBigInteger('hotel_companyid')->nullable();
            $table->foreign('hotel_companyid')->references('id')->on('hotel_company')->onDelete('cascade');
            $table->unsignedBigInteger('bus_companyid')->nullable();
            $table->foreign('bus_companyid')->references('id')->on('bus_company')->onDelete('cascade');
            $table->unsignedBigInteger('restaurant_companyid')->nullable();
            $table->foreign('restaurant_companyid')->references('id')->on('restaurant_company')->onDelete('cascade');

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
        Schema::dropIfExists('subpage');
    }
}
