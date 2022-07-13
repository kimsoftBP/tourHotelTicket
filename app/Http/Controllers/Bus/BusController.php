<?php

namespace App\Http\Controllers\Bus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bus;
use App\BusAvailable;
use App\BusAvailableType;
use App\BusCompany;
use App\BusCompanyPermission;
use App\BusType;
use App\BusMessage;
use App\LogBusSearch;
use Illuminate\Support\Facades\DB;

use App\Jobs\SendBusContactMail;
use Auth;

class BusController extends Controller
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

        $sessionid=session()->getId();
        if($search['from']!=NULL){
            LogBusSearch::create([
                'sessionid'=>$sessionid,
                'persons'=>$search['persons'],
                'from_date'=>$search['fromdate'],
                'to_date'=>$search['todate'],
                'from'=>$search['from'],
                ]);
        }

        $data['brand']=BusType::groupBy('brand')->orderby('brand')->get();
        $data['search']=$search;
        //DB::enableQueryLog(); 
        //$param['pending']=BusAvailableType::where('name','Pending')->first()->id;
        $param['available']=BusAvailableType::where('name','Available')->first()->id;

        $data['bus']=Bus::
                with(['BusType','BusCompany','availableCalendar'])
                ->where('passenger_seats','>=',$search['persons'])

                /*
                  ->whereHas('available',function($query)use($search,$param){
                  })
                  */


                /**
                 * reverse logic check 
                 * problem not set data .....
                 * 
                 * the daily calendar data 
                 * **/
/***
SELECT * 
FROM `bus` 
LEFT JOIN (SELECT COUNT(id), bus_id FROM bus_available_calendar WHERE date >= "2022-07-07" AND date <="2022-07-12" ) AS dlist
ON bus.id = dlist.bus_id
ORDER BY `created_at` DESC
                **/
                ->whereDoesntHave('available',function($query)use($search,$param){
                    $query->where(function($query)use($search,$param){
                            $query->where('date','<=',$search['fromdate'])
                                ->where('to_date','>',$search['fromdate'])
                                ->where('bus_available_typeid','!=',$param['available'])
                                ->where('remove','like',0);
                            });
                })
                ->whereDoesntHave('available',function($available)use($search,$param){
                    $available
                        ->where(function($query2)use($search,$param){
                            $query2->where('date','<',$search['todate'])
                                ->where('to_date','<=',$search['todate'])
                                ->where('bus_available_typeid','!=',$param['available'])
                                ->where('remove','like',0);
                        });
                })

                ->whereHas('BusCompany',function($queryCompany)use($search,$param){
                    $queryCompany->where('city','like','%'.$search['from'].'%'); 
                })
                ->groupBy('bus_companyid')
                ->groupBy('bustypeid')
                ->orderBy('bus_companyid')
                ->get();
//dd(DB::getQueryLog()); 

        return view('bus.search')->with('data',$data);
    }

    public function Contact(Request $req){
        $validateDate=$req->validate([
            'from'=>'',
            'fromdate'=>'',
            'todate'=>'',
            'comp'=>'required|exists:App\BusCompany,id',
            'bustype'=>'required|exists:App\BusType,id',
            'persons'=>'',
            ]);
        $data['company']=BusCompany::where('id',$req->comp)->first();
        $data['from']=$req->from;
        $data['fromdate']=$req->fromdate;
        $data['todate']=$req->todate;
        $data['BusType']=BusType::where('id',$req->bustype)->first();
        $data['persons']=$req->persons;
        return view('bus.contact')->with('data',$data);
    }
    public function PostContact(Request $req){
        $validateDate=$req->validate([
            'bustype'=>'required|exists:App\BusType,id',
            'buscomp'=>'required|exists:App\BusCompany,id',
            'text'=>'required|string',
            ]);
        $user=Auth::user();
        $busCompUser=BusCompany::where('id',$req->buscomp)->first()->users()->first();
        echo $busCompUser->email;
        
        BusMessage::create([
            'to_mail'=>$busCompUser->email,
            'title'=>$req->title??'',
            'text'=>$req->text,
            'to_userid'=>$busCompUser->id,
            'from_userid'=>$user->id,
            'bus_companyid'=>$req->buscomp,
            //'reply_by_bus_messageid'=>'',
            'bus_typeid'=>$req->bustype,
            ]);
        $details = [
            'email'=>$busCompUser->email,
            'text'=>$req->text,
            'user'=>$user,
            'locale'=>app()->getLocale(),
            ];
         SendBusContactMail::dispatch($details);
         $details=[
            'email'=>'tour@kimsoft.at',
            ];
        SendBusContactMail::dispatch($details);
         return redirect()->route('bus.search',app()->getLocale())->with('success',__('messages.sendComplete'));
    }
}
