<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAvailable extends Model
{
    //
    protected $table="product_available";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'productid','available_uiid',
        'date','hour',
        'created_at','updated_at',
        ];
    public function product(){
        return $this->hasOne('App\Product','id','productid');
    }
    public function availableUi(){
        return $this->hasOne('App\ProductAvailableUi','id','available_uiid');
    }
    public function ticketavailable(){
        return $this->hasMany('App\ProductTicketAvailablePiece','availableid','id');
    }
} 
