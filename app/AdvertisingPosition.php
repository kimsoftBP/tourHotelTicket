<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisingPosition extends Model
{
    //
    protected $table="advertising_position";
    protected $primaryKey="id";
    protected $fillable = [
        'page','name'
        ];
    public function include(){
        return $this->hasMany('App\AdvertisingPositionInclude','advertisingpositionid','id');
    }
}
