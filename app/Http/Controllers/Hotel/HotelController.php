<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Hotel;

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
}
