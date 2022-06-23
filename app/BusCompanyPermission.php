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
}
