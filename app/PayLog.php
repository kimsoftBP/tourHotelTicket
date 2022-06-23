<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayLog extends Model
{
    protected $table="paylog";
    protected $primaryKey="id";
    protected $fillable = [
        'id','event','text','status','checkoutid','checkoutRef','reservation_payid','created_at','updated_at',
    ];
    public function reservation(){
        return $this->hasOne('App\ReservationPay','id','reservation_payid');
    }
}
