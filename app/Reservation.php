<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
   	protected $table="reservation";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','paystatus','currencyid','date','priceperperson','person','sumprice','reservateduserid','productid','cloneproductid','created_at','updated_at','token','token2','refound_amount','hour',
    ];
    public function product()
    {
        return $this->hasOne('App\Product','id','productid');
    }
    public function cloneproduct(){
        return $this->hasOne('App\CloneProduct','id','cloneproductid');
    }

    public function currency(){
        return $this->hasOne('App\Currency','id','currencyid');
    }
    public function ticket(){
        return $this->hasMany('App\ReservationTicket','reservationid','id');
    }
    public function user(){
        return $this->hasOne('App\User','id','reservateduserid');
    }

}
