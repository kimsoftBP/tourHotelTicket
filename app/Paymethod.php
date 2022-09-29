<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paymethod extends Model
{
    protected $table="paymethod";
    protected $primaryKey="id";
    protected $fillable = [
        'id','name','client_id','client_secret','email','created_at','updated_at',
    ];
    public function reservationpay(){
        return $this->hasMany('App\ReservationPay','paymethodid','id');
    }
}
