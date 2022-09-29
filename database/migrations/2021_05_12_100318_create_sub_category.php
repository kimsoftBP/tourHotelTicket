<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('categoryid');
            $table->foreign('categoryid')->references('id')->on('category')->onDelete('cascade');
            $table->timestamps();
        });

        $category=DB::table('category')->where('name','tour')->first();
        DB::table('sub_category')->insert([
                    ['name'=>'Bus/Taxi','categoryid'=>$category->id],
                    ['name'=>'City','categoryid'=>$category->id],
                    ['name'=>'museum','categoryid'=>$category->id],
                    ['name'=>'Audio','categoryid'=>$category->id],
                    ['name'=>'Suburban','categoryid'=>$category->id],
                    ['name'=>'Night','categoryid'=>$category->id],
                    ['name'=>'unique','categoryid'=>$category->id],
                    ['name'=>'Nature','categoryid'=>$category->id],
                    ['name'=>'Custom','categoryid'=>$category->id]
                     ]);
        $category=DB::table('category')->where('name','admission ticket')->first();       
        DB::table('sub_category')->insert([
                    ['name'=>'Theme park','categoryid'=>$category->id],
                    ['name'=>'Zoo/Aquarium','categoryid'=>$category->id],
                    ['name'=>'museum','categoryid'=>$category->id],
                    ['name'=>'history/culture spots','categoryid'=>$category->id],
                    ['name'=>'Nature','categoryid'=>$category->id],
                    ['name'=>'performance/musical','categoryid'=>$category->id],
                    ['name'=>'other/combo','categoryid'=>$category->id]
                     ]);
        $category=DB::table('category')->where('name','activity')->first();       
        DB::table('sub_category')->insert([
                ['name'=>'snorkeling/diving','categoryid'=>$category->id],
                ['name'=>'surfing','categoryid'=>$category->id],
                ['name'=>'water activities','categoryid'=>$category->id],
                ['name'=>'cruise/yacht','categoryid'=>$category->id],
                ['name'=>'golf','categoryid'=>$category->id],
                ['name'=>'indoor','categoryid'=>$category->id],
                ['name'=>'extreme','categoryid'=>$category->id],
                ['name'=>'outdoor','categoryid'=>$category->id],
                ['name'=>'unique','categoryid'=>$category->id]
            ]);
        $category=DB::table('category')->where('name','class')->first();       
        DB::table('sub_category')->insert([
                ['name'=>'cooking/baking','categoryid'=>$category->id],
                ['name'=>'leather/accessories','categoryid'=>$category->id],
                ['name'=>'handicraft','categoryid'=>$category->id],
                ['name'=>'art/music/photo','categoryid'=>$category->id],
                ['name'=>'flower/candle/perfume','categoryid'=>$category->id],
                ['name'=>'health/beauty','categoryid'=>$category->id],
                ['name'=>'yoga/meditation','categoryid'=>$category->id],
                ['name'=>'unique','categoryid'=>$category->id]
                ]);
        $category=DB::table('category')->where('name','snap shooting')->first();       
        DB::table('sub_category')->insert([
                ['name'=>'wedding/honemoon','categoryid'=>$category->id],
                ['name'=>'friendship/lover/family','categoryid'=>$category->id],
                ['name'=>'single person','categoryid'=>$category->id],
                ['name'=>'studio/group','categoryid'=>$category->id]
                ]);
        $category=DB::table('category')->where('name','delicacies')->first();       
        DB::table('sub_category')->insert([
                ['name'=>'meal voucher','categoryid'=>$category->id]
                ]);
        $category=DB::table('category')->where('name','Spa/Healing')->first();       
        DB::table('sub_category')->insert([
                ['name'=>'spa/massage','categoryid'=>$category->id],
                ['name'=>'health/beauty','categoryid'=>$category->id]
                ]);
        $category=DB::table('category')->where('name','Transportation')->first();       
        DB::table('sub_category')->insert([
                ['name'=>'rent a car','categoryid'=>$category->id],
                ['name'=>'airport transfer','categoryid'=>$category->id],
                ['name'=>'baggage delivery/others','categoryid'=>$category->id],
                ['name'=>'other transportation','categoryid'=>$category->id]
                ]);
        $category=DB::table('category')->where('name','rental')->first();       
        DB::table('sub_category')->insert([
                ['name'=>'sim/wifi','categoryid'=>$category->id],
                ['name'=>'shooting supplies','categoryid'=>$category->id],
                ['name'=>'picnic/camping supplies','categoryid'=>$category->id],
                ['name'=>'other rental services','categoryid'=>$category->id]
                ]);
   //     $category=DB::table('category')->where('name','package')->first();       
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_category');
    }
}
