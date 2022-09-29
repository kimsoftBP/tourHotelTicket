<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelMessage extends Model
{
    //
    protected $table="hotel_message";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'to_mail','title','text','to_userid','from_userid','hotel_companyid','reply_by_hotel_messageid',
        'created_at','updated_at',
        ];
}
