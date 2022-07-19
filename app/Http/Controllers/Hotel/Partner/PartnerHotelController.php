<?php

namespace App\Http\Controllers\Hotel\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Hotel;
use App\HotelCompany;
use App\HotelCompanyPermission;
use App\HotelRoom;
use App\HotelRoomAvailable;

use Auth;
use Carbon\Carbon;

class PartnerHotelController extends Controller
{
    //
    public function index(Request $req){
        $user=Auth::user();
        $data['hotel']=$user->HotelCompanyPermission->first()->HotelCompany->first();
        $data['hotelroom']=$user->HotelCompanyPermission->first()->HotelCompany->first()->room;
        return view('partner.hotel.index')->with('data',$data);
    }



    public function addRoom(Request $req){
        $validateDate=$req->validate([
            'name'=>'required',
            'piece'=>'required|integer|min:1',
            'people'=>'required|integer|min:1',
            'hid'=>'required|exists:App\Hotel,id',            
            ]);
        HotelRoom::create([
            'name'=>$req->name,
            'maximum_people'=>$req->people,
            'piece'=>$req->piece,
            'hotelid'=>$req->hid,
            ]);
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
    public function editRoom(Request $req){
        $validateDate=$req->validate([
            'rid'=>'required|exists:App\HotelRoom,id',
            ]);
        $data['room']=HotelRoom::where('id',$req->rid)->first();
        $rdata['html']=view('partner.hotel.ajax.editroom')->with('data',$data)->render();
        return response()->json($rdata,200);
    }
    public function postEditRoom(Request $req){
        $validateDate=$req->validate([
            'rid'=>'required|exists:App\HotelRoom,id',
            'name'=>'required',
            'piece'=>'required|integer|min:1',
            'people'=>'required|integer|min:1',
            ]);
        HotelRoom::where('id',$req->rid)->update([
            'name'=>$req->name,
            'piece'=>$req->piece,
            'maximum_people'=>$req->people,
            ]);
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
    public function deleteRoom(Request $req){
        $validateDate=$req->validate([
            'rid'=>'required|exists:App\HotelRoom,id',
            ]);
        HotelRoom::where('id',$req->rid)->delete();
        return redirect()->back()->with('success',__('messages.deletecompete'));
    }


    public function getAvailable(Request $req){
        $validateDate=$req->validate([

            ]);
        $data['id']=$req->rid;
        /*
        $data['bus']=Bus::
            with(['available','BusCompany','availableCalendar'])

            ->where('id',$req->id)
            ->whereHas('BusCompany',function($query)use($user){
                $query->whereHas('permission',function($squery)use($user){
                    $squery->where('userid',$user->id);
                });
            })
            ->first();
        if($data['bus']==NULL){// dont have permission or not find
            abort(403);
        } */



        /***
         * previous , actual , next 
         * year, month
         * **/
        $data['year']=now()->format('Y');
        $data['month']=now()->format('m');
        if($req->year!=NUll && is_numeric($req->year) ){
            $data['year']=$req->year;
        }
        if($req->month!=NUll &&  is_numeric($req->month) && $req->month>0 && $req->month<=12){
            $data['month']=$req->month;          
        }
        $data['nextmonth']=$data['month']+1;
        $data['startdate']=Carbon::createFromDate($data['year'].'-'.$data['month'].'-01');
        $next=clone $data['startdate'];
        $previous=clone $data['startdate'];
        $next->addMonths(1);
        $previous->addMonths(-1);
        $data['previousYear']=$previous->format('Y');
        $data['previousMonth']=$previous->format('m');
        $data['nextyear']=$next->format('Y');
        $data['nextmonth']=$next->format('m');
        /***
         * 
         **/
        $data['availableCalendar']=[];
        $data['room']=HotelRoom::where('id',$req->rid)->first();
        $rdata['html']=view('partner.hotel.ajax.calendar')->with('data',$data)->render();
        return response()->json($rdata,200);
    }
    public function available(Request $req){
        $validateDate=$req->validate([
            'available.*'=>'',//available room * the days
            'year'=>'',
            'month'=>'',
            'rid'=>'required|exists:App\HotelRoom,id',
            ]);
        $now=now();
        foreach($req->available as $key=>$row){
            HotelRoomAvailable::updateOrCreate([
                'hotel_roomid'=>$req->rid, 
                'date'=>$req->year.'-'.$req->month.'-'.$key
                ],[
                    'piece'=>$row,
                ]);
        }
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
}
