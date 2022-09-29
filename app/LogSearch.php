<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogSearch extends Model
{
    protected $table="log_search";
    protected $primaryKey="id";
    protected $fillable = [
        'id','search','categoryid','category','subcategory','cityid','minprice','maxprice','grade','toursizeid','toursize','languageid','language','time','meetingtime','sessionid','created_at','updated_at'
    ];
    public function language(){
        return $this->hasOne('App\Language','id','languageid');
    }

    public function category(){
        return $this->hasOne('App\Category','id','categoryid');
    }
    public function city(){
        return $this->hasOne('App\City','id','cityid');
    }
    public function toursize(){
        return $this->hasOne('App\TourSize','id','tourcourseid');
    }
}
