<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReservationTicket extends Model
{
   	protected $table="reservation_ticket";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','title','shortdesc','price','currencyid','ticketid','created_at','updated_at','piece','sumprice','eticket','reservationid'
    ];
}
