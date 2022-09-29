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
        'created_at','updated_at',
        ];
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
