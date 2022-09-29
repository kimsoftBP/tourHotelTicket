<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusFind extends Model
{
    //
    protected $table="bus_find";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'from','from_date','to_time',
        'to','to_date','to_time',
        'created_at','updated_at'
        ];
    public function User(){
        return $this->hasOne('App\User','id','userid');
    }
}
