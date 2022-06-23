<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->id();
            $table->string('paystatus')->nullable();
            $table->unsignedBigInteger('currencyid');
            $table->foreign('currencyid')->references('id')->on('currency');
            $table->date('date');
            $table->integer('priceperperson');            
            $table->integer('person');
            $table->integer('sumprice')->nullable();//with tickets

            $table->unsignedBigInteger('reservateduserid');//not foreign key directly delete problem cascade....
            $table->unsignedBigInteger('productid');//same when delete product not delete pay and reservation data
            $table->unsignedBigInteger('cloneproductid');
            

            //$table->foreign('userid')->references('id')->on('user')


            

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
        Schema::dropIfExists('reservation');
    }
}
