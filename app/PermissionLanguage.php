<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionLanguage extends Model
{
    protected $table="permission_language";
    protected $primaryKey="id";
    protected $fillable = [
        'id','userid','languageid','addedbyuserid','created_at','updated_at'
    ];
    public function language(){
        return $this->hasOne('App\Language','id','languageid');
    }
}
