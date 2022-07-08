<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\PermissionName;

class SetPermTourToPermissionNameTable extends Migration
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
        $perm=PermissionName::where('perm_name','like','partner')->update(['perm_name'=>'partner tour/ticket']);
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
        $perm=PermissionName::where('perm_name','like','partner tour/ticket')->update(['perm_name'=>'partner']);
    }
}
