<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalInformationToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->boolean('additionalhotel')->default(false);
            $table->boolean('additionalflightdeparture')->default(false);
            $table->boolean('additionalairarrival')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropColumn([
                'additionalairarrival',
                'additionalflightdeparture',
                'additionalhotel',
            ]);
        });
    }
}
