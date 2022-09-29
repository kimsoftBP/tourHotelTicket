<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductTicketAvailablePiece extends Model
{
    //
    protected $table="product_ticket_available_piece";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'availableid','piece',
        'created_at','updated_at',
        ];
    public function availableDate(){
        return $this->hasOne('App\ProductAvailable','id','availableid');
    }
    public function ticketAvailable(){
        return $this->hasMany('App\ProductTicketAvailable','product_ticket_available_piece_id','id');
    }
    
}
