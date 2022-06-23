<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('countryid')->nullable();
            $table->foreign('countryid')->references('id')->on('country')->onDelete('cascade');
            $table->unsignedBigInteger('cityid')->nullable();
            $table->foreign('cityid')->references('id')->on('city')->onDelete('cascade');

            $table->unsignedBigInteger('categoryid')->nullable();
            $table->foreign('categoryid')->references('id')->on('category')->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('onelinesummary',500)->nullable();
            $table->string('introduction',3000)->nullable();

            $table->unsignedBigInteger('toursizeid')->nullable();
            $table->foreign('toursizeid')->references('id')->on('tour_size')->onDelete('cascade');

            $table->integer('minimumnumberofdepartures')->nullable();

            $table->dateTimeTz('availableto')->nullable();
            
            //$table->dateTimeTz('')
            $table->date('meetingdate')->nullable();
            $table->time('meetingtime')->nullable();


            $table->string('meetingplacename')->nullable();
            $table->string('meetingplacecoordinate')->nullable();

            $table->integer('totalrequiredday')->nullable();
            $table->integer('totalrequiredhour')->nullable();
            $table->integer('totalrequiredminute')->nullable();

            $table->string('priceincluded',2000)->nullable();
            $table->string('notincluded',2000)->nullable();
            $table->string('essentialguidance',2000)->nullable();/* please inform us about ho to dress and what to prepare ......   */
            
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');

            /*Many
                -lang-
                subcategory
                photo
                meeting photo
            */
            /*One
                vehicle
            */

            $table->unsignedBigInteger('vehicleid')->nullable();
            $table->foreign('vehicleid')->references('id')->on('product_vehicle')->onDelete('cascade');
            $table->timestamps();

            /*
vehicle
    -vehivle movement
    -go on foot
    -etc

photo
    //We have confirmed that the registered photos do not infringe on the rights of third parties (portrait rights, copyrights, etc.) and are commercially available. *


photo meeting place


Tour course
    (
    title
    time hour,minute required
    course content
    photo
    )+++

price
    -simple pricing
        -minimum number of people
        -maximum number of people

        price per person
        -currency
        -amount
    -price per person  //arsavok
        (
        -personel /number
        -currency
        -amount
        )

            */
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
