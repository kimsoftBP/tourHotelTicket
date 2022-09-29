<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSpoken extends Model
{
    protected $table="user_spoken_language";
    protected $primaryKey="id";
    protected $fillable = [
        'id','userid','languageid','created_at','updated_at'
    ];

    public function user(){
        return $this->hasOne('App\User','id','userid');
    }
    public function language(){
        return $this->hasOne('App\Language','id','languageid');
    }
}

