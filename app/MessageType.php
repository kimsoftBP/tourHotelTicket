<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageType extends Model
{
   	protected $table="message_type";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','name','created_at','updated_at',
    ];
}
