<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
   	protected $table="continents";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','created_at','updated_at'
    ];
    public function regions(){
      return $this->hasMany('App\Region','continentid','id');
    }
}
