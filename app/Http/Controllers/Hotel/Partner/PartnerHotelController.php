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

class PartnerHotelController extends Controller
{
    //
    public function index(Request $req){
        $user=Auth::user();
        $data['hotel']=$user->HotelCompanyPermission->first()->HotelCompany->first()->room;
        return view('partner.hotel.index')->with('data',$data);
    }
}
