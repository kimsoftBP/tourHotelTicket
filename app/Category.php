<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   	protected $table="category";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','created_at','updated_at','iconfilename',
    ];
    public function subcategory(){
      return $this->hasMany('App\SubCategory','categoryid','id');
    }
    public function product(){
    	return $this->hasMany('App\Product','categoryid','id');
    }
}
