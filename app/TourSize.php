<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourSize extends Model
{
   	protected $table="tour_size";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','created_at','updated_at'
    ];
}
