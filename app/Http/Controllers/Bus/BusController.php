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
use Illuminate\Support\Facades\DB;

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
                    $queryCompany->where('city',$search['from']); 
                })
                ->groupBy('bus_companyid')
                ->groupBy('bustypeid')
                ->orderBy('bus_companyid')
                ->get();
//dd(DB::getQueryLog()); 

        return view('bus.search')->with('data',$data);
    }
}
