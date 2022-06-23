<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
   	protected $table="product_price";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','currencyid','productid','minimumpeople','maximumpeople','person','created_at','updated_at','notes','amount',
    ];
    public function currency(){
    	return $this->hasOne('App\Currency','id','currencyid');
    }
}
