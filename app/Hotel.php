<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
    protected $table="hotel";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name','city','address','countryid','hotel_companyid',
        'created_at','updated_at',
        ];
}
