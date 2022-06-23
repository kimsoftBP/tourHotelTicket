<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->unsignedBigInteger('regionid');
            $table->foreign('regionid')->references('id')->on('regions')->onDelete('cascade');

            $table->timestamps();
        });

        DB::table('continents')->insert([
            ['name'=>'Europe'],]);
            $id=DB::table('continents')->where('name','Europe')->first();
            DB::table('regions')->insert([
                ['name'=>'Western europe',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Western europe')->first();
                DB::table('country')->insert([
                    ['name'=>'Netherlands',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Germnay',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Luxembourg',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Monaco',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Belgium',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Swiss',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Ireland',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'England',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Austria',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Italy',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'France',
                     'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                ['name'=>'Southern Europe',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Southern Europe')->first();
                DB::table('country')->insert([
                    ['name'=>'Greece',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Montenegro',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Malta',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Bosnia and Herzegovina',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Cyprus',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Spain',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Slovenian',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'British Gibraltar',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Croatia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Turkey',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Portugal',
                     'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                ['name'=>'Eastern Europe',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Eastern Europe')->first();
                DB::table('country')->insert([
                    ['name'=>'Latvia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Russia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Romania',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Lithuania',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Macedonian',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Bulgaria',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Serbia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Slovakia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Estonia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Ukraine',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Georgia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Czech Republic',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Poland',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Hungary',
                     'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                ['name'=>'North Europe',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','North Europe')->first();
                DB::table('country')->insert([
                    ['name'=>'Norway',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Denmark',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Sweden',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Iceland',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Finland',
                     'regionid'=>$region->id],]);


        DB::table('continents')->insert([
            ['name'=>'Asia'],]);
            $id=DB::table('continents')->where('name','Asia')->first();
            DB::table('regions')->insert([
                ['name'=>'domestic',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','domestic')->first();
                DB::table('country')->insert([
                        ['name'=>'Republic of Korea',
                         'regionid'=>$region->id],]);                
            DB::table('regions')->insert([
                ['name'=>'Southeast Asia',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Southeast Asia')->first();
                DB::table('country')->insert([
                        ['name'=>'Laos',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Malaysia',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Maldive Islands',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Myanmar',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Vietnam',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Brunei',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Indonesia',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Cambodia',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Thailand',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Philippines',
                         'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                ['name'=>'China/Japan',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','China/Japan')->first();
                DB::table('country')->insert([
                        ['name'=>'Japan',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'China',
                         'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                ['name'=>'Hong Kong/ Macau/ Taiwan/ Singapore',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Hong Kong/ Macau/ Taiwan/ Singapore')->first();
                DB::table('country')->insert([
                        ['name'=>'Taiwan',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Macau',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Singapore',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Hong Kong',
                         'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                ['name'=>'india / Central and South Asia',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','india / Central and South Asia')->first();
                DB::table('country')->insert([
                        ['name'=>'Nepal',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Mongolia',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Bangladesh',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Sri Lanka',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Uzbekistan',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'India',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Kazakhstan',
                         'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                ['name'=>'Middle East',
                 'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Middle East')->first();
                DB::table('country')->insert([
                        ['name'=>'United Arab Emirates',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Armenia',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Azerbaijan',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Jordan',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Israel',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'catarrh',
                         'regionid'=>$region->id],]);

        DB::table('continents')->insert([
            ['name'=>'America'],]);
            $id=DB::table('continents')->where('name','America')->first();
            DB::table('regions')->insert([
                    ['name'=>'USA /Canada',
                     'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','USA /Canada')->first();
                DB::table('country')->insert([
                        ['name'=>'United States of America',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Canada',
                         'regionid'=>$region->id],]);
            DB::table('regions')->insert([
                    ['name'=>'Latin America',
                     'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Latin America')->first();
                DB::table('country')->insert([
                        ['name'=>'Guatemala',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Dominican Republic',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Mexico',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Virgin islands',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Bolivia',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Brazil',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Argentina',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'El Salvador',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Uruguay',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Chile',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Costa Rica',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Columbia',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Cuba',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Panama',
                         'regionid'=>$region->id],]);
                DB::table('country')->insert([
                        ['name'=>'Peru',
                         'regionid'=>$region->id],]);


        DB::table('continents')->insert([
            ['name'=>'Oceania'],]);
            $id=DB::table('continents')->where('name','Oceania')->first();
            DB::table('regions')->insert([
                    ['name'=>'Australia / New Zealand',
                     'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Australia / New Zealand')->first();
                DB::table('country')->insert([
                    ['name'=>'New Zealand',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'sebum',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Australia',
                     'regionid'=>$region->id],]);


            DB::table('regions')->insert([
                    ['name'=>'South Pacific',
                     'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','South Pacific')->first();
                DB::table('country')->insert([
                    ['name'=>'Guam',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Saipan',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Palau',
                     'regionid'=>$region->id],]);

        DB::table('continents')->insert([
            ['name'=>'Africa'],]);
            $id=DB::table('continents')->where('name','Africa')->first();
            DB::table('regions')->insert([
                    ['name'=>'Africa',
                     'continentid'=>$id->id],]);
                $region=DB::table('regions')->where('name','Africa')->first();
                DB::table('country')->insert([
                    ['name'=>'Namibia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Nigeria',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Republic of South Africa',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Morocco',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Algeria',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Egypt',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Zambia',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Kenya',
                     'regionid'=>$region->id],]);
                DB::table('country')->insert([
                    ['name'=>'Tanzania',
                     'regionid'=>$region->id],]);
        
                
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $region=DB::table('regions')->delete();
        $continet=DB::table('continents')->delete();
        Schema::dropIfExists('country');
    }
}
