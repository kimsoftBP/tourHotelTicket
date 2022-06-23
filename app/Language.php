<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
   	protected $table="language";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','code','created_at','updated_at'
    ];

    public function productlanguage(){
		return $this->hasOne('App\ProductLanguage','languageid','id');
	}   
}
