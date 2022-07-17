<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelCompanyPermission extends Model
{
    //
    protected $table="hotel_company_permission";
    protected $primaryKey="id";
    protected $fillable=[
        'id',        
        'userid','hotel_companyid',
        'created_at','updated_at',
        ];
    public function HotelCompany(){
        return $this->hasOne('App\HotelCompany','id','hotel_companyid');
    }
    public function user(){
        return $this->hasOne('App\User','id','userid');
    }
}
