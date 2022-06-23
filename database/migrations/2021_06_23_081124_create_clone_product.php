<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCloneProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clone_product', function (Blueprint $table) {
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
 
            $table->date('meetingdate')->nullable();
            $table->time('meetingtime')->nullable();


            $table->string('meetingplacename')->nullable();
            $table->string('meetingplacecoordinate')->nullable();

            $table->integer('totalrequiredday')->nullable();
            $table->integer('totalrequiredhour')->nullable();
            $table->integer('totalrequiredminute')->nullable();

            $table->string('priceincluded',2000)->nullable();
            $table->string('notincluded',2000)->nullable();
            $table->string('essentialguidance',2000)->nullable();
            
            $table->unsignedBigInteger('userid');
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');


            $table->unsignedBigInteger('vehicleid')->nullable();
            $table->foreign('vehicleid')->references('id')->on('product_vehicle')->onDelete('cascade');
            $table->timestamps();

            $table->boolean('page1')->default(false);
            $table->boolean('page2')->default(false);
            $table->boolean('page3')->default(false);
            $table->boolean('checkadmin')->default(false);
            $table->boolean('nocity')->default(false);
            $table->boolean('photorights')->default(false);

            $table->boolean('additionalhotel')->default(false);
            $table->boolean('additionalflightdeparture')->default(false);
            $table->boolean('additionalairarrival')->default(false);
            
            $table->unsignedBigInteger('pricetypeid')->nullable();
            $table->foreign('pricetypeid')->references('id')->on('price_type')->onDelete('cascade');
            
            
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clone_product');
    }
}
