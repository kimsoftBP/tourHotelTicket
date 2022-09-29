<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourCourse extends Model
{
   	protected $table="tour_course";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','title','content','hour','minute','productid','created_at','updated_at'
    ];

    public function photo(){
		return $this->hasMany('App\TourCoursePhoto','tour_courseid','id');
	}
	public function log(){
		return $this->hasMany('App\TourCourseChangeLogConfirm','tour_courseid','id');
	}
}
