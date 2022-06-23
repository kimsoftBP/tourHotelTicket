<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DataAddNotneedconfirmationToPermissionName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_name', function (Blueprint $table) {
            //ű
            DB::table('permission_name')->insert([
                ['perm_name'=>'not_need_confirmation'],
                ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_name', function (Blueprint $table) {
            DB::table('permission_name')->where('perm_name','not_need_confirmation')->delete();
        });
    }
}
