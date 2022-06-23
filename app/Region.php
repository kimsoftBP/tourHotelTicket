<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
   	protected $table="regions";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','continentid','created_at','updated_at'
    ];
    public function country(){
      return $this->hasMany('App\Country','regionid','id');
    }
    public function continent(){
      return $this->hasOne('App\Continent','id','continentid');
    }
}
