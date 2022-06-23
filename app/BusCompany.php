<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusCompany extends Model
{
    //
    protected $table="bus_company";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'name',
        'created_at','updated_at',
        ];
    public function buses(){
        return $this->hasMany('App\Bus','bus_companyid','id');
    }
}
