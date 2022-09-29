<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantCompanyPermission extends Model
{
    //
    protected $table="restaurant_company_permission";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'userid','restaurant_companyid',
        'created_at','updated_at',
        ];
    public function user(){
        return $this->hasOne('App\User','id','userid');
    }
    public function RestaurantCompany(){
        return $this->hasOne('App\RestaurantCompany','id','restaurant_companyid');
    }
}
