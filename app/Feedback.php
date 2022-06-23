<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
   	protected $table="feedback";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','productid','userid','star','text','created_at','updated_at','namearray',
    ];
}
