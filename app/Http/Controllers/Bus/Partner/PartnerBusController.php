<?php

namespace App\Http\Controllers\Bus\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bus;
use App\BusType;
use App\BusCompany;

use Auth;

class PartnerBusController extends Controller
{
    //
    public function index(Request $req){


    }
    public function buses(Request $req){
        $data['user']=Auth::user()->load(['BusCompany']);
        $data['company']=$data['user']->BusCompany->first();
        $data['buses']=$data['company']->buses??NULL;
        $data['brand']=BusType::groupBy('brand')->get();
        $data['year']=now()->format('Y');
        //print_r($data['buses']=$data['user']->BusCompany->first()->buses);
        //echo $user->BusCompany->first()->name;
        return view('partner.bus.buses')->with('data',$data);
    }

    public function addBus(Request $req){
        $validateDate=$req->validate([
            'brand'=>'required|string',
            'model'=>'required|string',
            'year'=>'required|string',
            'licensePlate'=>'required|string',//|unique:App\Bus,license_plate',  /**not one country use same license plate format .... **/
            'company'=>'required|exists:App\BusCompany,id',
            ]);
        $bustype=BusType::updateOrCreate([
            'brand'=>$req->brand,
            'name'=>$req->model,
            ],[
            ]);

        Bus::create([
            'bustypeid'=>$bustype->id,
            'bus_companyid'=>$req->company,
            //'piece'=>
            'license_plate'=>$req->licensePlate,
            //'basecity'=>
            ]);
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }


    public function ajaxModel(Request $req){
        $validateDate=$req->validate([
            'brand'=>'required|string',
            ]);
        $data['model']=BusType::where('brand',$req->brand)->orderBy('name')->get();
        return response()->json($data,200);
    }
}
