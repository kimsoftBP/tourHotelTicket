<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{
   	protected $table="product_subcategory";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','productid','subcategoryid','created_at','updated_at'
    ];

    public function category(){
    	return $this->hasOne('App\SubCategory','id','subcategoryid');
    }
}
