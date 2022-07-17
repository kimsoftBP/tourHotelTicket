<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelCompany extends Model
{
    //
    protected $table="hotel_company";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name','postcode','address','tax_number','city','countryid',
        'created_at','updated_at',
        ];
    public function permission(){
        return $this->hasMany('App\HotelCompanyPermission','hotel_companyid','id');
    }
    public function room(){
        return $this->hasMany('App\HotelRoom','hotelid','id');
    }
}
