<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourCoursePhoto extends Model
{
   	protected $table="tour_course_photo";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','photoid','tour_courseid','created_at','updated_at'
    ];
    public function photo(){
		return $this->hasOne('App\Photo','id','photoid');
	}
}
