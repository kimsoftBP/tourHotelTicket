<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    //
    protected $table="bus";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'bustypeid','bus_companyid','basecity','license_plate','passenger_seats','luggage_places','year',
        'piece',//NULL csak akkor kell ha egyben x db
        'currencyid','price_per_km','price_per_day',
        'created_at','updated_at',
        ];
    public function Currency(){
        return $this->hasOne('App\Currency','id','currencyid');
    }
    public function BusCompany(){
        return $this->hasOne('App\BusCompany','id','bus_companyid');
    }
    public function BusType(){
        return $this->hasOne('App\BusType','id','bustypeid');
    }
    public function available(){
        return $this->hasMany('App\BusAvailable','busid','id');
    }
    public function availableCalendar(){
        return $this->hasMany('App\BusAvailableCalendar','bus_id','id');
    }
}
