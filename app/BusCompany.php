<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusCompany extends Model
{
    //
    protected $table="bus_company";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name','postcode','address','tax_number','countryid','city',
        'created_at','updated_at',
        ];
    public function country(){
        return $this->hasOne('App\Country','id','countryid');
    }
    public function buses(){
        return $this->hasMany('App\Bus','bus_companyid','id');
    }
    public function permission(){
        return $this->hasMany('App\BusCompanyPermission','bus_companyid','id');
    }
}
