<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusAvailableCalendar extends Model
{
    //
    protected $table="bus_available_calendar";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'date','year','month','day','bus_availableid','bus_id','bus_available_typeid',
        'created_at','updated_at'
        ];
    public function available(){
        return $this->hasOne('App\BusAvailable','id','bus_availableid');
    }
    public function bus(){
        return $this->hasOne('App\Bus','id','bus_id');
    }
    public function type(){
        return $this->hasOne('App\BusAvailableType','id','bus_available_typeid') ;
    }

}
