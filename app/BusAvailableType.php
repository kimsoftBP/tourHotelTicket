<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusAvailableType extends Model
{
    //
    protected $table="bus_available_type";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'created_at','updated_at'
        ];
    public function available(){
        return $this->hasMany('App\BusAvailable','bus_available_typeid','id');
    }
    
}
