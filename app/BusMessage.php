<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusMessage extends Model
{
    //
    protected $table="bus_message";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'mail','title','text','to_userid','from_userid',
        'created_at','updated_at',
        ];

    public function FromUser(){
        return $this->hasOne('App\User','id','from_userid');
    }
    public function ToUser(){
        return $this->hasOne('App\User','id','to_userid');
    }
}
