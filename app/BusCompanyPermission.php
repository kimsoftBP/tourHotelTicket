<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusCompanyPermission extends Model
{
    //
    protected $table="bus_company_permission";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'userid','bus_companyid',
        'created_at','updated_at',
        ];
    public function User(){
        return $this->hasOne('App\User','id','userid');
    }
    public function Company(){
        return $this->hasOne('App\BusCompany','id','bus_companyid');
    }

}
