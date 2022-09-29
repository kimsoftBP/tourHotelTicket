<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertising extends Model
{
    //
    protected $table="advertising";
    protected $primaryKey="id";
    protected $fillable = [
        'text','name','available_end','available_start','url',//'file','path',
        ];
    public function include(){
        return $this->hasMany('App\AdvertisingPositionInclude','advertisingid','id');
    }
    public function files(){
        return $this->hasMany('App\AdvertisingFile','advertisingid','id');        
    }
}
