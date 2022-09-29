<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPageValidationRowsToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->boolean('page1')->default(false);
            $table->boolean('page2')->default(false);
            $table->boolean('page3')->default(false);
            $table->boolean('checkadmin')->default(false);
            $table->boolean('nocity')->default(false);
            $table->boolean('photorights')->default(false);
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
            $table->dropColumn(['page1']);
            $table->dropColumn(['page2']);
            $table->dropColumn(['page3']);
            $table->dropColumn(['checkadmin']);
            $table->dropColumn(['nocity']);
            $table->dropColumn(['photorights']);
        });
    }
}


