<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
   	protected $table="message";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','title','text','replybyid','touserid','fromuserid','typeid','productid','created_at','updated_at',
    ];
    public function type(){
    	return $this->hasOne('App\MessageType','id','typeid');
    }
    public function product(){
    	return $this->hasOne('App\Product','id','productid');
    }
    public function from(){
    	return $this->hasOne('App\User','id','fromuserid');
    }
    public function to(){
    	return $this->hasOne('App\User','id','touserid');
    }
    public function replyby(){
    	return $this->hasOne('App\Message','id','replybyid');
    }
}
