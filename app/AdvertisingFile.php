<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdvertisingFile extends Model
{
    //
    protected $table="advertising_file";
    protected $primaryKey="id";
    protected $fillable = [
        'id','name','path','advertisingid',
        ];
    public function advertising(){
        return $this->hasOne('App\Advertising','id','advertisingid');
    }
}
