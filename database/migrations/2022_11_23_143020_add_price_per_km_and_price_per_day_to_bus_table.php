<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricePerKmAndPricePerDayToBusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('currencyid')->nullable();
            $table->foreign('currencyid')->references('id')->on('currency')->onDelete('cascade');
            $table->double('price_per_km',8,2)->nullable();
            $table->integer('price_per_day')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus', function (Blueprint $table) {
            //
            $table->dropForeign(['currencyid']);
            $table->dropColumn(['price_per_day','price_per_km']);
        });
    }
}
