<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToPermissionNameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permission_name', function (Blueprint $table) {
            //
            DB::table('permission_name')->insert([
                ['perm_name'=>'continent admin'],                
                ]);
            DB::table('permission_name')->insert([
                ['perm_name'=>'moderator'],
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
            DB::table('permission_name')->where('perm_name','continent admin')->delete();
            DB::table('permission_name')->where('perm_name','moderator')->delete();
        });
    }
}
