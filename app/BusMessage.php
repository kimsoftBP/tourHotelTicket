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
        'to_mail','title','text','to_userid','from_userid','bus_companyid','reply_by_bus_messageid','bus_typeid',
        'created_at','updated_at',
        ];

    public function FromUser(){
        return $this->hasOne('App\User','id','from_userid');
    }
    public function ToUser(){
        return $this->hasOne('App\User','id','to_userid');
    }
}
