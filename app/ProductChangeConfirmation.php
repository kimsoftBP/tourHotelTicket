<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductChangeConfirmation extends Model
{
    
	protected $table="product_change_log_confirmation";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','title','onelinesummary','introduction','meetingplacename','meetingplacecoordinate','priceincluded','notincluded','essentialguidance','confirmbyuserid','created_at','updated_at','productid',
    ];
    public function user(){
    	return $this->hasOne('App\User','id','confirmbyuserid');
    }
}
