<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CloneProduct extends Model
{
   	protected $table="clone_product";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','countryid','cityid','categoryid','title','onelinesummary','introduction','toursizeid','minimumnumberofdepartures','availableto','meetingdate','meetingtime','meetingplacename','meetingplacecoordinate','totalrequiredday','totalrequiredminute','totalrequiredhour','priceincluded','notincluded','essentialguidance','userid','vehicleid','created_at','updated_at','page1','page2','page3','checkadmin','nocity','photorights','pricetypeid','additionalairarrival','additionalflightdeparture','additionalhotel',
        'admin_check_message','remove',
    ];

    public function country(){
        return $this->hasOne('App\Country','id','countryid');
    }
    public function city(){
        return $this->hasOne('App\City','id','cityid');
    }  
}
