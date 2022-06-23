<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusType extends Model
{
    //
    protected $table="bus_type";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name','brand','seat','luggage_places',
        'created_at','updated_at',
        ];
}
