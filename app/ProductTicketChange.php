<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTicketChange extends Model
{
   	protected $table="product_ticket_change_log";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','title','shortdesc','confirmbyuserid','product_ticketid','created_at','updated_at',
    ];
}
