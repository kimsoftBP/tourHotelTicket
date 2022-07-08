<?php

namespace App\Http\Controllers\Bus\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Bus;
use App\BusType;
use App\BusCompany;
use App\BusCompanyPermission;
use App\BusAvailable;
use App\BusAvailableType;
use App\BusAvailableCalendar;


use Auth;
use Carbon\Carbon;

class PartnerBusController extends Controller
{
    /***
     * 
     * */
    public function index(Request $req){

        return view('partner.bus.dashboard');
    }
    public function buses(Request $req){
        $data['user']=Auth::user()->load(['BusCompany']);
        $data['company']=$data['user']->BusCompany->first();
        //print_r($data['user']);
    //    print_r($data['company']);
    //    print_r($data['user']->BusCompany);

        $data['buses']=$data['company']->buses??NULL;
        $data['brand']=BusType::groupBy('brand')->get();
        $data['year']=now()->format('Y');
        $data['month']=now()->format('m');
        $data['busAvailableType']=BusAvailableType::orderBy('name')->get();
        if($req->month!=NUll &&  is_numeric($req->month) && $req->month>0 && $req->month<12){
            $data['month']=$req->month;          
        }
        //$data['month']=8;
       // echo $data['month'];
        //print_r($data['buses']=$data['user']->BusCompany->first()->buses);
        //echo $user->BusCompany->first()->name;
        $data['dates']=10;
        $data['startdate']=Carbon::createFromDate($data['year'].'-'.$data['month'].'-01');
        return view('partner.bus.buses')->with('data',$data);
    }

    public function addBus(Request $req){
        $validateDate=$req->validate([
            'brand'=>'required|string',
            'model'=>'required|string',
            'year'=>'required|string',
            'seat'=>'required',
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
            'passenger_seats'=>$req->seat,
            //'basecity'=>
            ]);
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }

    public function deleteBus(Request $req){
        $validateDate=$req->validate([
            'bus'=>'required|exists:App\Bus,id',
            ]);
        Bus::where('id',$req->bus)->delete();
        return redirect()->back()->with('success',__('messages.deletecompete'));
    }
    
    public function postEditBus(Request $req){
        $validateDate=$req->validate([
            'brand'=>'required|string',
            'model'=>'required|string',
            'year'=>'required|string',
            'licensePlate'=>'required|string',//|unique:App\Bus,license_plate',  /**not one country use same license plate format .... **/
            'bus'=>'required|exists:App\Bus,id',
            //'company'=>'required|exists:App\BusCompany,id',
        ]);
        $bustype=BusType::updateOrCreate([
            'brand'=>$req->brand,
            'name'=>$req->model,
            ],[
            ]);
        Bus::updateOrCreate(
            [
                'id'=>$req->bus,
                ],[
            'bustypeid'=>$bustype->id,
            'year'=>$req->year,
           // 'bus_companyid'=>$req->company,
            //'piece'=>
            'license_plate'=>$req->licensePlate,
            'passenger_seats'=>$req->seat,
            //'basecity'=>
            ]);
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }


    public function editBus(Request $req){
        $validateDate=$req->validate([
            'bus'=>'required|exists:App\Bus,id',
            ]);
        $data['bus']=Bus::with(['BusType'])
                ->where('id',$req->bus)->first();
        $data['year']=now()->format('Y');
        $rdata['edithtml']=view('partner.bus.ajax.busEdit')->with('data',$data)->render();
        return response()->json($rdata,200);
    }
    public function ajaxModel(Request $req){
        $validateDate=$req->validate([
            'brand'=>'required|string',
            ]);
        $data['model']=BusType::where('brand',$req->brand)->orderBy('name')->get();
        return response()->json($data,200);
    }

    /**
     * available Calendar
     * **/
    public function ajaxAvailableBus(Request $req){
        $data['id']=$req->id;
        $user=Auth::user();
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
        }        
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
        $data['availableCalendar']=BusAvailableCalendar::
                where('year',$data['year'])
                ->where('month',$data['month'])
                ->where('bus_id',$data['bus']->id)
                ->orderBy('date')
                ->get();         
        $rdata['html']=view('partner.bus.ajax.calendar')->with('data',$data)->render();
        return response()->json($rdata,200);
    }

    public function newAvailableC(Request $req){
        $validateDate=$req->validate([
            'bus'=>'required|exists:App\Bus,id',

            'fromDate'=>'required|date',
            'fromTime'=>'nullable|string',
            'toDate'=>'required|date|after_or_equal:fromDate',
            'toTime'=>'nullable|string',
            'available'=>'required|exists:App\BusAvailableType,id|string'
            ]);
        $ch=BusAvailable::
            where('busid',$req->bus)
            ->where(function($check)use($req){
                $check->where(function($query)use($req){
                    $query->where('date','>=',$req->fromDate)
                        ->where('date','<',$req->toDate);
                })
                ->orWhere(function($query2)use($req){
                    $query2->where('to_date','>',$req->fromDate)
                        ->where('to_date','<=',$req->toDate);
                });
            })
            ->count();
        if($ch>0){
            $error = \Illuminate\Validation\ValidationException::withMessages([
               'fromDate' => ['Validation Message #1'],
               //'field_name_2' => ['Validation Message #2'],
            ]);
            throw $error;
        }
        $date1=Carbon::createFromDate($req->fromDate);
        $date2=Carbon::createFromDate($req->toDate);

        $diff=$date2->diffInDays($date1);  
        $bavailable=BusAvailable::create([
            'busid'=>$req->bus,
            'date'=>$req->fromDate,
            'from_time'=>$req->fromTime,
            'to_time'=>$req->toTime,
            'to_date'=>$req->toDate,
            'bus_available_typeid'=>$req->available,
            //'city'=>
            'days'=>$diff+1,
            ]);
        $first=0;
        //while($date2->diffInDays($date1)>0){
        $j=0;
        while ($diff>=$j) {
            BusAvailableCalendar::create([
                'date'=>$date1->format('Y-m-d'),
                'year'=>$date1->format('Y'),
                'month'=>$date1->format('m'),
                'day'=>$date1->format('d'),
                'bus_availableid'=>$bavailable->id,
                'bus_id'=>$req->bus,
                'bus_available_typeid'=>$req->available,
                ]);
            $date1->addDay();
            $j++;
        }
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
    public function loadEditAvailable(Request $req){
        $validateDate=$req->validate([
            'id'=>'required|exists:App\BusAvailable,id',
            ]);
        $data['busAvailableType']=BusAvailableType::orderBy('name')->get();
        $data['available']=BusAvailable::where('id',$req->id)->first();
        $rdata['html']=view('partner.bus.ajax.editCalendarIntervallum')->with('data',$data)->render();
        return response()->json($rdata,200);
    }
    public function editAvailable(Request $req){
        $validateDate=$req->validate([
            'editAvailable'=>'required|exists:App\BusAvailable,id',

            'fromDate'=>'required|date',
            'fromTime'=>'nullable|string',
            'toDate'=>'required|date|after_or_equal:fromDate',
            'toTime'=>'nullable|string',
            'available'=>'required|exists:App\BusAvailableType,id|string'
        ]);
        $bAv=BusAvailable::where('id',$req->editAvailable)->first();
        $ch=BusAvailable::
            where('busid',$bAv->busid)
            ->where('id','!=',$bAv->id)
            ->where(function($check)use($req){
                $check->where(function($query)use($req){
                    $query->where('date','>=',$req->fromDate)
                        ->where('date','<',$req->toDate);
                })
                ->orWhere(function($query2)use($req){
                    $query2->where('to_date','>',$req->fromDate)
                        ->where('to_date','<=',$req->toDate);
                });
            })
            ->count();
        if($ch>0){
            $error = \Illuminate\Validation\ValidationException::withMessages([
               'fromDate' => ['Validation Message #1'],
               //'field_name_2' => ['Validation Message #2'],
            ]);
            throw $error;
        }
        $date1=Carbon::createFromDate($req->fromDate);
        $date2=Carbon::createFromDate($req->toDate);

        $diff=$date2->diffInDays($date1);  
        BusAvailable::where('id',$req->editAvailable)->update([
            'date'=>$req->fromDate,
            'from_time'=>$req->fromTime,
            'to_time'=>$req->toTime,
            'to_date'=>$req->toDate,
            'bus_available_typeid'=>$req->available,
            //'city'=>
            'days'=>$diff+1,
            ]);
        
        $first=0;
        $now=now();
        $j=0;
        while ($diff>=$j) {
            BusAvailableCalendar::updateOrCreate(
                [
                    'bus_id'=>$bAv->busid,
                    'bus_availableid'=>$bAv->id,
                    'date'=>$date1->format('Y-m-d'),
                    'year'=>$date1->format('Y'),
                    'month'=>$date1->format('m'),
                    'day'=>$date1->format('d'),
                ],[

                    'bus_available_typeid'=>$req->available,
                    'updated_at'=>$now
                ]);
            $date1->addDay();
            $j++;
        }
        BusAvailableCalendar::where('bus_availableid',$bAv->id)->where('updated_at','<',$now)->delete();
        return redirect()->back()->with('success',__('messages.savecomplete'));
    }
}
