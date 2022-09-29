<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\Reservation;
use App\ReservationTicket;
use App\Product;
use App\CloneProduct;
use App\ProductPrice;
use App\ProductTicket;
use App\Paymethod;
use App\Jobs\SendReservationEmail;
use App\Jobs\SendPartnerReservationEmail;
use App\Country;

class UserController extends Controller
{
    public function account(){
    	$user=Auth::user();
    	return view('user.account')->with('user',$user);
    }
    public function verifycomplete(){
        return view('user.verifycomplete');
    }

    public function edit(){
    	$user=Auth::user();
        $data['country']=Country::get();
    	return view('user.account_edit')->with('user',$user)->with('data',$data);
    }
    public function postedit(Request $req){
        $validateDate=$req->validate([
            'name' => ['required', 'string', 'max:255'],
            'phonenumber'=>'nullable|string',
            'country'=>'nullable|exists:country,id',
            'city'=>'nullable|string',
        ]);
        $user=Auth::user();
        $user->name=$req->name;
        $user->phonenumber=$req->phonenumber;
        $user->countryid=$req->country;
        $user->city=$req->city;
        $user->save();
        return redirect(route('account',app()->getLocale()))->with('success', 'Save complete');  
    }
    public function changepassword(){
    	return view('user.account_changepassword');
    }
    public function postchangepassword(Request $req){
    	$validateDate=$req->validate([
    		'password' => ['required', 'string', 'min:8', 'confirmed'],    		
    	]);    	    	
    	$user=Auth::user();
    	if(!Hash::check($req->currentpassword, $user->password)){
    	//if($user->password!=Hash::make($req->currentpassword)){
    		$error=\Illuminate\Validation\ValidationException::withMessages([
    			'currentpassword'=>[__('messages.wrongpassword')]]);
    		throw $error;
        	//return redirect()->back()->with('error', 'Save complete');  
    	}
    	$user->password=Hash::make($req->password);
    	$user->save();
    	return vieW('user.account')->with('user',$user)->with('message','Save complete');
    }
    
    public function postreservation(Request $req){
        $validateDate=$req->validate([
            'product'=>'required|exists:product,id',
            'person'=>'required|integer|min:1',
            'date'=>'required|date',
            'ticket.*'=>'', //ticket[][0] ticket id  || ticket[][1] number
            ]);
        $user=Auth::user();
        $product=Product::where('id',$req->product)->first();
//        $productprice=$product->price;

        $maxprice=$product->priceorderbymaximumpeople->first();
        if($maxprice->maximumpeople!=NULL && $maxprice->maximumpeople<$req->person ){
            $error = \Illuminate\Validation\ValidationException::withMessages([
               //'person' => ['This course maximum people limit '.$maxprice->maximumpeople],
                'person' => [__('messages.This course maximum people limit').$maxprice->maximumpeople],
            ]);
            throw $error;
        }
        $minpeaople=$product->priceorderbyminimumpeople->first();
        if($minpeaople->minimumpeople!=NULL && $minpeaople->minimumpeople>$req->person){
            $error = \Illuminate\Validation\ValidationException::withMessages([
               'person' => [__('messages.This course minimum people limit').$minpeaople->minimumpeople],
            ]);
            throw $error;
        } 

        
        $cloneproduct=CloneProduct::updateOrCreate([
                'countryid'=>$product->countryid,
                'cityid'=>$product->cityid,
                'categoryid'=>$product->categoryid,
                'title'=>$product->title,
                'onelinesummary'=>$product->onelinesummary,
                'introduction'=>$product->introduction,
                'toursizeid'=>$product->toursizeid,
                'minimumnumberofdepartures'=>$product->minimumnumberofdepartures,
                'availableto'=>$product->availableto,
                'meetingdate'=>$product->meetingdate,
                'meetingtime'=>$product->meetingtime,
                'meetingplacename'=>$product->meetingplacename,
                'meetingplacecoordinate'=>$product->meetingplacelocation,
                'totalrequiredday'=>$product->totalreqday,
                'totalrequiredhour'=>$product->totalreqhour,
                'totalrequiredminute'=>$product->totalreqmin,
                'priceincluded'=>$product->priceincluded,
                'notincluded'=>$product->notincluded,
                'essentialguidance'=>$product->essentialguidance,
                'userid'=>$product->userid,
                'vehicleid'=>$product->vehicleid,
            ]);

        $productprice=ProductPrice::where('productid',$product->id)
            ->where(function($query) use($req){
                $query->orWhereNull('minimumpeople')
                    ->orWhere('minimumpeople','<=',(int)$req->person)
                    ;
            })
            ->where(function($query2)use ($req){
                $query2->orWhereNull('maximumpeople')
                    ->orWhere('maximumpeople','>=',$req->person);
            })
            ->first();

        if($productprice==NULL){
            $error = \Illuminate\Validation\ValidationException::withMessages([
               'errors' => ['Error'],
            ]);
            throw $error;
        }
        /*
$company=Company::whereHas('cperm',function(Builder $query) use ($userid){
            $query->whereRaw('usersid like '.$userid);
            });



where(function($query){
                $query->orWhere('permission',3)
                  ->orWhere('permission',2);
              })->get();

        $productprice=$product->price->whereRaw('((minimumpeople <='.$req->people.' OR minimumpeople LIKE NULL ) AND ( maximumpeople >='.$req->people.') OR maximumpeople LIKE NULL )')->first();
        print_r($productspart);*/


        //echo "<br>";
        $reservation=Reservation::create([
            //'paystatus'=>
            'currencyid'=>$product->price->first()->currencyid,
            'date'=>$req->date,
            'priceperperson'=>$productprice->amount,
            'person'=>$req->person,
            //'sumprice'=>
            'reservateduserid'=>$user->id,
            'productid'=>$product->id,
            'cloneproductid'=>$cloneproduct->id,
            'hour'=>$req->hour??NULL,
                ]);
        
        $sumprice=0;
 

        //print_r($req->)
        //foreach ($req->ticket as $inticket) {//ticket[][0] ticket id  || ticket[][1] number
        if($req->ticket!=NULL){
            for ($i=0; $i < count($req->ticket); $i++) { 
           
            //    echo "id:".$req->ticketid[$i]." per:".$req->ticket[$i];
                //echo "id:".$req->ticketid[$i];
                
                if($req->ticket[$i]>0 && is_numeric($req->ticketid[$i]) && $req->ticketid[$i]>0){
                    $ticket=ProductTicket::where('id',$req->ticketid[$i])->first();
             //       print_r($inticket);
                    $ticketsumprice=$ticket->price*$req->ticket[$i];
                    $sumprice+=$ticketsumprice;
                    ReservationTicket::create([
                        'title'=>$ticket->title,
                        'shortdesc'=>$ticket->shortdesc,
                        'price'=>$ticket->price,
                        'eticket'=>$ticket->eticket??0,
                        'currencyid'=>$ticket->currencyid,
                        'ticketid'=>$ticket->id,
                        'reservationid'=>$reservation->id,
                        'piece'=>$req->ticket[$i],
                        'sumprice'=>$ticketsumprice,
                        ]);
                }else{

                  
                }
            }
        }
        $sumprice+= $req->person*$productprice->amount;
        $reservation->sumprice=$sumprice;
        $reservation->save();




        $details = [
            'email' => $user->email,                
            'product'=>$product,
            'reservation'=>$reservation,
            'locale'=>app()->getLocale(),
        ];
        /*        
        SendReservationEmail::dispatch($details);
        $details['email']=$product->user->email;
        SendPartnerReservationEmail::dispatch($details);
        $details['email']="sales@kimsoft.at";
        SendPartnerReservationEmail::dispatch($details);
        */
//        return redirect()->back()->with('success', __('messages.reservationcomplete'));
     // 
        return redirect(route('paymethods',['locale'=>app()->getLocale() , 'res'=>$reservation->id ]) );//->with('reservation',$reservation);  
    }
    //FAILED  PENDING 
    public function selectpaymethod(Request $req){
        $validateDate=$req->validate(['res'=>'required|exists:reservation,id']);        
        $data['reservation']=Reservation::where('id',$req->res)->first();
        $data['paymethods']=Paymethod::get();
        return view('user.selectpaymethod')->with('data',$data);
    }

    public function orders(Request $req){
        $user=Auth::user();
        $data['orders']=Reservation::where('reservateduserid',$user->id)->get();
        return view('user.orders')->with('data',$data);
    }

}
