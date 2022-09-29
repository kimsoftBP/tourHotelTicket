<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductLanguage extends Model
{
   	protected $table="product_language";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','productid','languageid','created_at','updated_at'
    ];

    public function language(){
		return $this->hasOne('App\Language','id','languageid');
	}   
	public function product(){
		return $this->hasOne('App\Product','id','productid');
	}
}
