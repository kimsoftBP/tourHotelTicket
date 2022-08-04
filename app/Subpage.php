<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subpage extends Model
{
    //
    protected $table="subpage";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'title','text','text_area2','text_area3','data',
        'hotel_companyid','bus_companyid','restaurant_companyid',
        'created_at','updated_at',
        ];

    public function HotelCompany(){
        return $this->hasOne('App\HotelCompany','id','hotel_companyid');
    }
    public function BusCompany(){
        return $this->hasOne('App\BusCompany','id','bus_companyid');
    }
    public function RestaurantCompany(){
        return $this->hasOne('App\RestaurantCompany','id','restaurant_companyid');
    }
    public function SubpagePhotos(){
        return $this->hasMany('App\SubpagePhoto');
    }
    
    public function SubpageMainPhoto(){
        return $this->hasMany('App\SubpagePhoto','subpageid','id')->where('photo_group',0);
    }
    public function SubpageOtherPhoto(){
        return $this->hasMany('App\SubpagePhoto','subpageid','id')->where('photo_group','!=',0);
    }
}
