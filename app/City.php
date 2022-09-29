<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
   	protected $table="city";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','countryid','created_at','updated_at','namearray',
    ];
    public function photos(){
      return $this->hasMany('App\CityImages','cityid','id');
    }
    

    public function country(){
      return $this->hasOne('App\Country','id','countryid');
    }

    public function products(){
      return $this->hasMany('App\Product','cityid','id')->where('remove',0);
    }
}
