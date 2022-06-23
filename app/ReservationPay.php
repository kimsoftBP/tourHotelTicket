<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationPay extends Model
{
    protected $table="reservation_pay";
    protected $primaryKey="id";
    protected $fillable = [
        'id','reservationid','paymethodid','checkoutid','checkoutRef','status','created_at','updated_at','amount','refound_amount',
    ];

    public function paymethod(){
        return $this->hasOne('App\Paymethod','id','paymethodid');
    }
    public function reservation(){
        return $this->hasOne('App\Reservation','id','reservationid');
    }    
}
