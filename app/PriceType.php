<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceType extends Model
{
    protected $table="price_type";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','html','code','created_at','updated_at'
    ];
}
