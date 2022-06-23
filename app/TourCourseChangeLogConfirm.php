<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourCourseChangeLogConfirm extends Model
{
   	protected $table="tour_course_change_log_confirmation";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','title','content','tour_courseid','confirmbyuserid','created_at','updated_at'
    ];
    public function tourcourse(){
    	return $this->hasOne('App\TourCourse','id','tourcourseid');
    }
    public function user(){
    	return $this->hasOne('App\User','id','confirmbyuserid');
    }
}
