<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRegion extends Model
{
    protected $table="permission_region";
    protected $primaryKey="id";
    protected $fillable = [
        'id','userid','continentid','countryid','addedbyuserid','created_at','updated_at'
    ];
    public function continent(){
        return $this->hasOne('App\Continent','id','continentid');
    }
    public function country(){
        return $this->hasOne('App\Country','id','countryid');
    }
}
