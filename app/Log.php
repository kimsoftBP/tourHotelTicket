<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table="log";
    protected $primaryKey="id";
    protected $fillable = [
        'id','url','routename','sessionid','ip','ipv6','country','countrycode','state','city','referer','created_at','updated_at'
    ];


}
