<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionName extends Model
{
   	protected $table="permission_name";
	protected $primaryKey="id";
  	protected $fillable = [
        'id','perm_name','userid'
    ];
}
