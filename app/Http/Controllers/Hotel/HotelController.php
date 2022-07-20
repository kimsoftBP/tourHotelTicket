<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Hotel;
use App\HotelMessage;
use App\SendHotelContactMail;
use App\HotelCompany;

class HotelController extends Controller
{
    //
    public function search(Request $req){
        $validateDate=$req->validate([
            'from'=>'nullable|string',
            'daterange'=>'nullable|string',
            'persons'=>'nullable|integer',
            ]);
        $daterange=$req->daterange;        
        $search['from']=$req->from;
        $search['fromdate']=substr($daterange,0,13);
        $search['todate']=substr($daterange,13,strlen($daterange));
        $search['persons']=$req->persons??1;
        $search['range']=$req->daterange;

        $data['search']=$search;
        $data['hotel']=Hotel::with(['room'])
            ->where('city','like','%'.$search['from'].'%')
            ->whereHas('room',function($roomQuery)use($search){
                $roomQuery->whereDoesntHave('available',function($availableQuery)use($search){
                    $availableQuery->where('date','>',$search['fromdate'])
                        ->where('date','<',$search['todate'])
                        ->whereRaw('piece < '.$search['persons']);
                });
            })->get();
        return view('hotel.search')->with('data',$data);
    }


    public function Contact(Request $req){
        $validateDate=$req->validate([
            'from'=>'',
            'fromdate'=>'',
            'todate'=>'',
            'comp'=>'required|exists:App\HotelCompany,id',
            'persons'=>'',
            ]);
        $data['company']=HotelCompany::where('id',$req->comp)->first();
        $data['from']=$req->from;
        $data['fromdate']=$req->fromdate;
        $data['todate']=$req->todate;
        $data['persons']=$req->persons;

        $t=HotelCompany::where('city','like','%'.$req->from.'%')->groupBy('city')->get();
        $data['messageFrom']='';
        if(count($t)==1){
            $data['messageFrom']=$t->first()->city;
        }
        return view('hotel.contact')->with('data',$data);
    }
    public function PostContact(Request $req){
        $validateDate=$req->validate([
            'from'=>'',
            'fromdate'=>'',
            'todate'=>'',
            'comp'=>'required|exists:App\HotelCompany,id',
            'persons'=>'',
            ]);
        $user=Auth::user();
        $hotelCompUser=HotelCompany::where('id',$req->comp)->first()->user()->first();
        HotelMessage::create([
            'to_mail'=>$hotelCompUser->email,
            'title'=>$req->title??'',
            'text'=>$req->text,
            'to_userid'=>$hotelCompUser->id,
            'from_userid'=>$user->id,
            'hotel_companyid'=>$req->comp,
            ]);
        $details=[
            'email'=>$hotelCompUser->email,
            'text'=>$req->text,
            'title'=>$req->title??'',
            'user'=>$user,
            'locale'=>app()->getLocale(),
            ];
        SendHotelContactMail::dispatch($details);
        $details['email']="tour@kimsoft.at";
        SendHotelContactMail::dispatch($details);
        return redirect()->route('hotel.search',app()->getLocale())->with('success',__('messages.hotelContactSendSuccess'));
    }
}
