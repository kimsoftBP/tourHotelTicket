<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogHotelSearch extends Model
{
    //
    protected $table="log_hotel_search";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'sessionid','ip','persons','from_date','to_date','from',
        'created_at','updated_at',
        ];
}
