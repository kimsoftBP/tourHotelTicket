<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMeetingPhoto extends Model
{
   	protected $table="product_meeting_photo";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','productid','photoid','created_at','updated_at'
    ];
        public function photo(){
		return $this->hasOne('App\Photo','id','photoid');
	}
}
