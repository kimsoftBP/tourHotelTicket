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

    public function users(){
        //return $this->hasMany('App\BusCompany','id','')
        return $this->hasManyThrough(
            'App\User',//1st table
            'App\BusCompanyPermission',
            'bus_companyid',//foreign key on 2st table
            'id',//Foreign key on 1st table 
            'id',//Local Key on buscom table
            'userid',//Local Key on 2st table
            );//need get or first
    }
    public function Subpage(){
        return $this->hasMany('App\Subpage','bus_companyid','id');
    }
}
