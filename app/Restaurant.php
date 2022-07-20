<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    //
    protected $table="restaurant";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name','city','address','max_person','countryid','restaurant_companyid'
        'created_at','updated_at'
        ];
    public function Company(){
        return $this->hasOne('App\RestaurantCompany','id','restaurant_companyid');
    }
    public function Menu(){
        return $this->hasMany('App\RestaurantMenu','id','restaurantid');
    }
}
