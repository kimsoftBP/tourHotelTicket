<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductTicketAvailablePiece;

class ProductTicket extends Model
{
   	protected $table="product_ticket";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','title','shortdesc','price','expire','eticket','currencyid','productid','created_at','updated_at',
    ];
    public function currency(){
    	return $this->hasOne('App\Currency','id','currencyid');
    }
    public function change(){
    	return $this->hasMany('App\ProductTicketChange','product_ticketid','id');
    }
    

    public function available(){
        return $this->hasMany('App\ProductTicketAvailable','product_ticket_id','id');
    }
    public function availableIn($date,$hour){

        $data=ProductTicketAvailablePiece::whereHas('ticketAvailable',function($query){
            $query->where('product_ticket_id',$this->id);
        })->whereHas('availableDate',function($date_query)use($date,$hour){
            $date_query->where('date',$date)
                ->where('hour',$hour);
        })
        ->first();
        return $data->piece??0;
    }

}
