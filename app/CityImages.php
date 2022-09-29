<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityImages extends Model
{
   	protected $table="city_images";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','folder','extension','cityid','created_at','updated_at','type','notes'
    ];
}
