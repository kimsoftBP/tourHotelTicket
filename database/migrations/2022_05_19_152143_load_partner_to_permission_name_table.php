<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\PermissionName;

class LoadPartnerToPermissionNameTable extends Migration
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
        });
        PermissionName::updateOrCreate([
            'perm_name'=>'partner',
            ]);
        PermissionName::updateOrCreate(['perm_name'=>'admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permission_name', function (Blueprint $table) {
            //
        });
    }
}
