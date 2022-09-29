<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
   	protected $table="permission";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','permid','userid','created_at','updated_at'
    ];
    /*
    public function permissionname(){
      return $this->hasOne('App\PermissionName','id','permid');
    }*/
    public function permissionName(){
      return $this->hasOne('App\PermissionName','id','permid');
    }
}
