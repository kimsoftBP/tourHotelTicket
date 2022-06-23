<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\PermissionName;

class LoadPartnerBusPermissionToPermissionName extends Migration
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
            'perm_name'=>'partner bus',
            ]);
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
        PermissionName::where('perm_name','partner bus')->delete();
    }
}
