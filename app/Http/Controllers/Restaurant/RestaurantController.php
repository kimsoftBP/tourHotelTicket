<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Restaurant;

class RestaurantController extends Controller
{
    //
    public function search(Request $req){
        $validateDate=$req->validate([
            'from'=>'nullable|string',
            ]);
        $search['from']=$req->from;
        $search['persons']='';
        $data['search']=$search;
        $data['restaurants']=Restaurant::where('city','like','%'.$req->from.'%')->get();
        return view('restaurant.search')->with('data',$data);
    }
    public function contact(Request $req){
        
    }
}
