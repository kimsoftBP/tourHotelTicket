<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
   	protected $table="photo";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','folder','extension','created_at','updated_at','checkadmin','confirmbyuserid'
    ];
}
