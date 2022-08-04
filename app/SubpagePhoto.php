<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubpagePhoto extends Model
{
    //
    protected $table="subpage_photo";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'photoid','subpageid','photo_group',
        'updated_at','created_at',
        ];
    public function Photo(){
        return $this->hasOne('App\Photo','id','photoid');
    }
    public function Subpage(){
        return $this->hasOne('App\Subpage','id','subpageid');
    }
}
