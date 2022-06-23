<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Reservation;

use Auth;

class DashboardController extends Controller
{
    //
    public function dashboard(Request $req){
        $user=Auth::user();
        $year=date("Y");
        $month=date("m");
        
        $data['order']=Reservation::selectRaw('COUNT(id) as num ,created_at,YEAR(created_at) as year , MONTH(created_at) as month ')
            ->whereHas('product', function ($query) use ($user) {
                return $query->where('userid',$user->id);
                    
            })
            ->groupByRaw("YEAR(created_at),MONTH(created_at)")
            ->get();

        /*
        $data['click']=LogViewProduct::selectRaw('*, COUNT(id) as num , YEAR(created_at) as year , MONTH(created_at) as month')
        
        click...
            country/City  
            category            
            sold
            month year
            */
        $data['soldstat']=DB::table('reservation')
            ->selectRaw('COUNT(reservation.id) as num ,  country.name as countryname , city.name as cityname, category.name as categoryname  

                ')
            //lastmonthnum=(SELECT COUNT(res.id) FROM reservation as res )
            ->leftJoin('product','reservation.productid','=','product.id')
            ->leftJoin('country','product.countryid','=','country.id')
            ->leftJoin('city','product.cityid','=','city.id')
            ->leftJoin('category','product.categoryid','=','category.id')

            //->whereRaw('YEAR(created_at) LIKE '.$year)
            //->whereRaw('MONTH(created_at) LIKE '.$month)
            ->groupByRaw('product.countryid, product.cityid , product.categoryid')
            ->groupByRaw('YEAR(reservation.created_at),MONTH(reservation.created_at)')
            ->get();
 
            
        $data['sold']=Reservation::selectRaw('count(id) as num, productid, YEAR(created_at) as year, MONTH(created_at) as month ,id')
            ->whereRaw('YEAR(created_at) LIKE '.$year)
            ->whereRaw('MONTH(created_at) LIKE '.$month)
            ->groupByRaw('productid ,YEAR(created_at),MONTH(created_at) ')
            ->get();
/*
        $data['soldr']=[];
        foreach($data['sold'] as $row){
            $data['soldr'][$row->id]['country']=$row->product->country->name;
            $data['soldr'][$row->id]['category']=$row->product->category->name;
            $data['soldr'][$row->id]['year']=$row->year;
            $data['soldr'][$row->id]['month']=$row->month;                        
            $data['soldr'][$row->id]['num']=$row->num;

            if($row->product->city!=NULL){
                $data['soldr'][$row->id]['city']=$row->product->city->name;
            }
        }
        */

        $soldlastmonth=Reservation::selectRaw('count(id) as num, productid, YEAR(created_at) as year, MONTH(created_at) as month ,id')
            ->whereRaw('YEAR(created_at) LIKE '.$year)
            ->whereRaw('MONTH(created_at) LIKE '.($month-1))
            ->groupByRaw('productid ,YEAR(created_at),MONTH(created_at) ')
            ->get();
        foreach($soldlastmonth as $row){
            $data['soldr'][$row->id]['country']=$row->product->country->name;
            $data['soldr'][$row->id]['category']=$row->product->category->name;
            $data['soldr'][$row->id]['lastmonthnum']=$row->num;
        }



        //    DB::enableQueryLog(); 

        $data['click']=DB::table('product')
            ->selectRaw('COUNT(log_view_product.id) as num , YEAR(log_view_product.created_at) as year, MONTH(log_view_product.created_at)as month ,product.countryid , product.cityid, product.categoryid, product.id , country.name as countryname , city.name as cityname, category.name as categoryname')
            ->leftJoin('log_view_product','product.id','=','log_view_product.productid')
            ->leftJoin('country','product.countryid','=','country.id')
            ->leftJoin('city','product.cityid','=','city.id')
            ->leftJoin('category','product.categoryid','=','category.id')
            ->where('product.checkadmin',1)
            ->whereRaw('YEAR(log_view_product.created_at) LIKE '.$year)
            ->whereRaw('MONTH(log_view_product.created_at) LIKE '.$month)
            ->groupByRaw('YEAR(log_view_product.created_at),MONTH(log_view_product.created_at)')
            ->groupByRaw('countryid, cityid, categoryid ')
            ->orderBy('num','DESC')
          //  ->limit(3)
            ->get();

        //dd(DB::getQueryLog()); 


/*
        ->product
        ->user
        /*->whereHas('user', function ($query2) use ($user){
                        return $query2->where('', '=', 1);
                    });*/
        
        return view('partner.dashboard')->with('data',$data);
    }
}
