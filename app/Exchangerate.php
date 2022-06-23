<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchangerate extends Model
{
   	protected $table="exchangerate";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','to','unit','currency','value','created_at','updated_at',
    ];
}
