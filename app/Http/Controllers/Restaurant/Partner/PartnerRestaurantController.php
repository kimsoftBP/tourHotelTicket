<?php

namespace App\Http\Controllers\Restaurant\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Restaurant;
use App\RestaurantMenu;
use App\Currency;
use Auth;
use Carbon\Carbon;

class PartnerRestaurantController extends Controller
{
    //
    public function index(Request $req){
        $user=Auth::user();
        $data['restaurant']=$user->RestaurantCompanyPermission->first()->RestaurantCompany->Restaurant->first();
        $data['currency']=Currency::get();
   //     echo $data['restaurant']->id;
     //   echo count($data['restaurant']->Menu);
        return view('partner.restaurant.menu')->with('data',$data);
    }


    public function AddMenu(Request $req){
        $validateDate=$req->validate([
            'rid'=>'required|exists:App\Restaurant,id',
            'title'=>'',
            'text'=>'required|string',
            'price'=>'required|integer|min:0',
            'currency'=>'required|exists:App\Currency,id',
            ]);
        RestaurantMenu::create([
            'title'=>$req->title,
            'text'=>$req->text,
            'price'=>$req->price,
            'currencyid'=>$req->currency,
            'restaurantid'=>$req->rid,]);
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
    public function GetEditMenu(Request $req){
        $validateDate=$req->validate(['menu'=>'required|exists:App\RestaurantMenu,id']);
        $data['menu']=RestaurantMenu::where('id',$req->menu)->first();
        $rdata['html']=view('partner.restaurant.ajax.editmenu')->with('data',$data)->render();
        return response()->json($rdata,200);
    }
    public function EditMenu(Request $req){
        $validateDate=$req->validate([
            'rid'=>'required|exists:App\Restaurant,id',
            'title'=>'',
            'text'=>'required|string',
            'price'=>'required|integer|min:0',
            'currency'=>'required|exists:App\Currency,id',
            'menu'=>'required|exists:App\RestaurantMenu,id',
            ]);
        RestaurantMenu::where('id',$req->menu)->update([
            'title'=>$req->title,
            'text'=>$req->text,
            'price'=>$req->price,
            'currencyid'=>$req->currency,
            'restaurantid'=>$req->rid,
                ]);
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
    public function DeleteMenu(Request $req){
        $validateDate=$req->validate([
            'menu'=>'required|exists:App\RestaurantMenu,id',
            ]);
        RestaurantMenu::where('id',$req->menu)->delete();
        return redirect()->back()->with('success',__('messages.deletecompete'));
    }
}
                                  