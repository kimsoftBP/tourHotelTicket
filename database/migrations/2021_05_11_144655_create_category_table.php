<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        DB::table('category')->insert([
                    ['name'=>'tour',],
                    ['name'=>'admission ticket',],
                    ['name'=>'activity',],
                    ['name'=>'class',],
                    ['name'=>'snap shooting',],
                    ['name'=>'delicacies',],
                    ['name'=>'Spa/Healing',],
                    ['name'=>'Transportation',],
                    ['name'=>'rental',]
                     ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
