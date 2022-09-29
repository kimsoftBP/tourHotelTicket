<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table="country";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','regionid','created_at','updated_at'
    ];
    public function cities(){
      return $this->hasMany('App\City','countryid','id');
    }

    public function region(){
      return $this->hasOne('App\Region','id','regionid');
    }
}
