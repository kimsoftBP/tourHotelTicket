<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisingPositionInclude extends Model
{
    //
    protected $table="advertising_position_include";
    protected $primaryKey="id";
    protected $fillable = [
        'advertisingid','advertisingpositionid',
    ];
    public function position(){
        return $this->hasOne('App\AdvertisingPosition','id','advertisingpositionid');
    }
    public function advertising(){
        return $this->hasOne('App\Advertising','id','advertisingid');
    }
}
