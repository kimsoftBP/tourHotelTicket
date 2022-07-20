<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantMenu extends Model
{
    //
    protected $table="restaurant_menu";
    protected $primaryKey="id";
    protected $fillable=[
        'id',
        'title','text','price','currencyid','restaurantid',
        'created_at','updated_at'
        ];
    public function Restaurant(){
        return $this->hasOne('App\Restaurant','id','restaurantid');
    }
}
