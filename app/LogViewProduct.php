<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogViewProduct extends Model
{
    protected $table="log_view_product";
    protected $primaryKey="id";
    protected $fillable = [
        'id','sessionid','productid','countryid','cityid','categoryid','toursizeid','meetingtime','totalrequiredday','totalrequiredhour','totalrequiredminute','vehicleid','created_at','updated_at'
    ];

    public function product(){
        return $this->hasOne('App\Product','id','productid');
    }
    public function country(){
        return $this->hasOne('App\Country','id','countryid');
    }
    public function city(){
        return $this->hasOne('App\City','id','cityid');
    }
    public function category(){
        return $this->hasOne('App\Category','id','categoryid');
    }
    public function toursize(){
        return $this->hasOne('App\TourSize','id','tourcourseid');
    }
    public function vehicle(){
        return $this->hasOne('App\Vehicle','id','vehicleid');
    }    
}
