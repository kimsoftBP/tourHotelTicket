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
        'created_at','updated_at','from',
        ];

    public function log(){
        return $this->hasMany('App\Log','sessionid','sessionid');
    }
    public function logsearch(){
        return $this->hasOne('App\LogSearch','sessionid','sessionid');
    }
}

