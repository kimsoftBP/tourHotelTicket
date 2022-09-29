<?php

namespace App\Http\Controllers\Bus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Region;
use App\Country;
use App\BusCompany;

use App\Subpage;
use Illuminate\Support\Facades\Validator;
class BusSubpageController extends Controller
{
    //
    public function subpage(Request $req, $locale,$region, $country,$pageid){
        $check['country']=$country;
        $check['region']=$region;
        $check['subpage']=$pageid;
        $validation = Validator::make($check ,[
            'region'=>'required|exists:App\Region,name',
            'country'=>'required|exists:App\Country,name',
            'subpage'=>'required|exists:App\Subpage,id',
        ]);
        $regionObj=Region::where('name',$region)->first();
        if($regionObj==NULL){abort(404);}//wrong region
        $countryObj=Country::where('name',$country)->where('regionid',$regionObj->id)->first();
        if($countryObj==NULL){abort(404);}//wrong country name or not in this region

        $data['subpage']=Subpage::where('id',$pageid)
            ->whereHas('BusCompany',function($query)use($countryObj){
                $query->where('countryid',$countryObj->id);
            })->first();
        if($validation->fails() || $data['subpage']==NULL) {
            abort(404);
        } else {
            //echo 'pass';
        }
        return view('bus.subpage')->with('data',$data);
    }
}
