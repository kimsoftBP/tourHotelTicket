<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Restaurant;
use App\Jobs\SendRestaurantContactMail;

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
    public function PostContact(Request $req){
        $validateDate=$req->validate([
            'title'=>'',
            'text'=>'required|string',
            ]);
        $user=Auth::user();
        $restaurantCompUser="";

        $details=[
            'email'=>$busfindUser->email,
            'text'=>$req->text,
            'title'=>$req->title??'',
            'user'=>$user,
            'locale'=>app()->getLocale(),
            ];
        SendRestaurantContactMail::dispatch($details);
        $details['email']='tour@kimsoft.at';
        SendRestaurantContactMail::dispatch($details);
    }
}
