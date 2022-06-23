<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTicketAvailable extends Model
{
    //
    protected $table="product_ticket_avai";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'product_ticket_available_piece_id','product_ticket_id',
        'created_at','updated_at',
        ];
    public function ticket(){
        return $this->hasOne('App\ProductTicket','id','product_ticket_id');
    }
    public function availablePiece(){
        return $this->hasOne('App\ProductTicketAvailablePiece','id','product_ticket_available_piece_id');
    }
}
