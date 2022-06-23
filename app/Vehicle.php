<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
   	protected $table="product_vehicle";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','created_at','updated_at'
    ];
}
