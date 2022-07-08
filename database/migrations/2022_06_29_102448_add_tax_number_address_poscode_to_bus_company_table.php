<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxNumberAddressPoscodeToBusCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bus_company', function (Blueprint $table) {        
            $table->string('postcode');
            $table->string('address');
            $table->string('tax_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bus_company', function (Blueprint $table) {
            $table->dropColumn(['name','postcode','address','tax_number']);
        });
    }
}
