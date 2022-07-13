<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogBusSearch extends Model
{
    //
    protected $table="log_bus_search";
    protected $primaryKey="id"; 
    protected $fillable=[
        'id',
        'sessionid','ip','persons','from_date','to_date',
        'created_at','updated_at'
        ];
}

