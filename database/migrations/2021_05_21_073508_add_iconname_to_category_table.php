<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIconnameToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->string('iconfilename')->nullable();

        });
        DB::table('category')->where('name','tour')->update(['iconfilename'=>'1_original.png']);
        DB::table('category')->where('name','admission ticket')->update(['iconfilename'=>'2_original.png']);
        DB::table('category')->where('name','activity')->update(['iconfilename'=>'3_original.png']);
        DB::table('category')->where('name','class')->update(['iconfilename'=>'4_original.png']);
        DB::table('category')->where('name','snap shooting')->update(['iconfilename'=>'5_original.png']);
        DB::table('category')->where('name','delicacies')->update(['iconfilename'=>'6_original.png']);
        DB::table('category')->where('name','Spa/Healing')->update(['iconfilename'=>'7_original.png']);
        DB::table('category')->where('name','Transportation')->update(['iconfilename'=>'8_original.png']);
        DB::table('category')->where('name','rental')->update(['iconfilename'=>'9_original.png']);        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn(['iconfilename']);
        });
    }
}
