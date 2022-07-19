<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    //
    public function search(Request $req){
        return view('restaurant.search')->with('data',$data);
    }
}
