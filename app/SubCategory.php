<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
   	protected $table="sub_category";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','categoryid','created_at','updated_at'
    ];
    public function category(){
      return $this->hasOne('App\Category','id','categoryid');
    }
    public function productsubcat(){
    	return $this->hasMany('App\ProductSubcategory','subcategoryid','id');
    }
}
