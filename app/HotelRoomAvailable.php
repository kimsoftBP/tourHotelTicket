<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelRoomAvailable extends Model
{
    //
    protected $table="hotel_room_available";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'date','piece','hotel_roomid',
        'created_at','updated_at',
        ];
    public function room(){
        return $this->hasOne('App\HotelRoom','id','hotel_roomid');
    }
}
