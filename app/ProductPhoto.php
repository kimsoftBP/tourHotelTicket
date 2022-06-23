<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
   	protected $table="product_photo";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','productid','photoid','created_at','updated_at','checkadmin',
    ];
    public function photo(){
		return $this->hasOne('App\Photo','id','photoid');
	}
}
