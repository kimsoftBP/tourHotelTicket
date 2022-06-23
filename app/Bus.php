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
        'bustypeid','bus_companyid','basecity','license_plate','passenger_seats','luggage_places',
        'piece',//NULL csak akkor kell ha egyben x db
        'created_at','updated_at',
        ];
    public function BusType(){
        return $this->hasOne('App\BusType','id','bustypeid');
    }
}
