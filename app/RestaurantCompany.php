<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantCompany extends Model
{
    //
    protected $table="restaurnat_company";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name','postcode','address','countryid','city','tax_number',
        'created_at','updated_at'
        ];
    public function Restaurant(){
        return $this->hasMany('App\Restaurant','restaurant_companyid','id');
    }
    public function Permission(){
        return $this->hasMany('App\RestaurantCompanyPermission','restaurant_companyid','id');
    }
}
