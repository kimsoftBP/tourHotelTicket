<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Continent;
use App\Country;
use App\Region;
use App\Currency;
use App\Language;
use App\Product;
use App\TourSize;
use App\City;
use App\Category;
use App\User;
use App\Permission;
use App\PermissionName;
use Illuminate\Support\Facades\Hash;
use App\LogViewProduct;
use App\Log;
use App\LogSearch;
use App\SubCategory;
use App\Advertising;

use App\Bus;
use App\BusCompany;
use App\BusCompanyPermission;
use App\BusAvailable;
use App\BusAvailableType;

use App\Hotel;
use App\HotelCompany;
use App\HotelCompanyPermission;

use App\Restaurant;
use App\RestaurantCompany;
use App\RestaurantCompanyPermission;

use App\Subpage;
use Carbon\Carbon;
class IndexController extends Controller
{
    public function IndexMultipleSearch(Request $req){

    }
    public function index(Request $req){
        $validateDate=$req->validate([
            'pax'=>'nullable|string',
            'City.*'=>'nullable|string',
            ]);
        $now=now();

/* available shareddata
        $data['tours']=Product::where('checkadmin',1)->where('remove',0)->count();
        $data['guides']=User::whereHas('permission',function($query){
                    $query->whereHas('permissionName',function($permquery){
                        $permquery->where('perm_name','partner');
                    });
                })->count();
        $data['destinations']=City::whereHas('products')->count();        
        */
        //products
        $data['serach_suggestions']=LogViewProduct::SelectRaw("*, COUNT('id') as num")
            ->groupBy('cityid')
            ->groupBy('categoryid')
            ->orderBy('num','DESC')
            ->limit(6)
            ->get();

        


    	$data['cities']=City::get();         
      //  echo session()->getId();
        $language=Language::where('code',app()->getLocale())->first();
        $data['cities']=City::
                selectRaw('city.* , COUNT(product.id) as cnum')
                ->leftJoin('product','city.id','=','product.cityid')
              //  ->where('product.checkadmin',1)            
                ->groupBy('city.id')
                ->orderBy('cnum','DESC')
                ->get();

        $order=rand(1,100); 
        $data['product']=Product::where('checkadmin',1)->where('remove',0)
            ->orderByRaw("RAND(".$order.")" )
            ->limit(32)
            ->get();
        
        $date=$now->year."-".$now->month."-".$now->day;        
        $data['advertising']=Advertising::
            where('available_start','<=',$date)
            ->where(function($query_end)use($now){
                $query_end->orWhere('available_end','>=',$now)
                    ->orWhereNull('available_end');
            })
            
            ->whereHas('include',function($query){
                $query->whereHas('position',function($querypos){
                    $querypos->where('page','index')
                        ->where('name','area1');
                });
            })
            ->get();
        $data['subpage']=Subpage::get();
        
        $data['s']['pax']="";
        $data['s']['city']=[];
        $data['s']['cityinputnumber']=1;
        $data['s']['restaurants']=[];
        $data['s']['bus']=[];
        if(is_array($req->City)){
            $daterange=$req->daterange;        
            $search['from']=$req->from;
            $search['fromdate']=substr($daterange,0,11);
            $search['fromdateObj']=Carbon::createFromDate($search['fromdate']);
            $search['todate']=substr($daterange,13,strlen($daterange));
            if($search['todate']!=NULL){
                $search['todateObj']=Carbon::createFromDate($search['todate']);
            }

            $data['s']['pax']=$req->pax;
            $data['s']['city']=$req->City;
            $data['s']['cityinputnumber']=count($req->City);

            $param['available']=BusAvailableType::where('name','Available')->first()->id;

            $search_restaurant_part=Restaurant::whereRaw('1=1');
            $search_bus_part=Bus::
                with(['BusType','BusCompany','availableCalendar'])
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
                });

            
            $cityquery="(";
                foreach($req->City as $s_city){
                    $s_city=DB::getPdo()->quote('%'.$s_city.'%');
                    if($cityquery!="("){$cityquery.=" or ";}
                    $cityquery.=" city LIKE ".$s_city." ";
                }
            $cityquery.=")";
            $search_restaurant_part->whereRaw($cityquery);
            $search_bus_part->whereHas('BusCompany',function($queryCompany)use($cityquery,$req){
                $queryCompany->where('city','like','%'.$req->City[0].'%');
            });

            $data['s']['restaurants']=$search_restaurant_part->get();
            $data['s']['bus']=$search_bus_part
                ->groupBy('bus_companyid')
                ->groupBy('bustypeid')
                ->orderBy('bus_companyid')
                ->limit(1)
                ->get();
        }

        
    	return view('index')->with('data',$data);
    }

    //public function search(Request $req,$slug){ from kutimoo ticket
    //   public function index($lang,$companyfolder="",$folder="",Request $req){    
    public function cities($lang,$slug){
    	$data['slug']=$slug;
        $data['city']=City::where('name',$slug)->first();
        $data['category']=Category::get();

        $language=Language::where('code',app()->getLocale())->first();
        $data['products']=Product::where('cityid',$data['city']->id)
            ->whereHas('language',function($query) use ($language){
                return $query->where('languageid',$language->id);
            })
            ->where('remove',0)
            ->where('checkadmin',1)
            ->get();
    	//print_r($slug);
        $searchsuggest=LogViewProduct::SelectRaw("*, COUNT('id') as num")
            ->where('cityid',$data['city']->id)
            ->groupBy('cityid')
            ->groupBy('categoryid')
            ->orderBy('num','DESC')
            ->limit(6)
            ->get();
    	return view('cities')->with('data',$data)->with('searchsuggest',$searchsuggest);
    }
    

    public function ajaxlistcities(Request $req){
        $id=$req->id;
        $old=$req->old;
        $msg="";
        //$msg=$id;
        //$msg="<option value=''>".__('messages.select')."</option>";
        $region=Country::where('name',$id)->first();
        foreach ($region->cities as $city) {
            $txt="";
            if($old==$city->name){
              $txt="selected";
            }

            $cit=json_decode($city->namearray,true);
            $name=$city->name;
            if($cit[app()->getLocale()]!=NULL){
                $name=$cit[app()->getLocale()];
            }
            
            $msg.='<div class="col-2 float-left"><a href="'.route('cities', ['locale'=>app()->getLocale(),'slug'=>$city->name]).'">'.$name.'</a></div>';
        //    $msg.="<option value='".$city->name."' ".$txt.">".$city->name."</option>";
        }
        return response()->json(array('msg'=> $msg), 200);
    }

    /**
     *search
     *
     *required country or city
     *return only tour language
     **/
    public function offers(Request $req){
        $page=$req->page;
        if(!is_numeric($page)){
            $page=1;
        }
        $q=$req->q;
        $limit=8*3;
        $sessionid=session()->getId();
       // $limit=1;
/*
        $curr=Currency::where('code','HUF')->first();
        $v=json_decode($curr->langcode );
        print_r($v);
        */
     //   echo $this->geteuro();

        $offset=0;
        $data['q']=$req->q;
        $data['grade']=$req->grade;
        $data['toursize']=$req->toursize;
        $data['qlanguage']=$req->language;
        $data['time']=$req->time;
        $data['meetingtime']=$req->meetingtime;
        $data['querycategory']=$req->category;
        $data['querysubcategory']=$req->subcat;



        //echo $q."<br>";
        $data['category']=Category::get();//has('product')->
  //      DB::enableQueryLog(); 
        $que=DB::connection()->getPdo()->quote("%".$q."%");
        $que2=DB::connection()->getPdo()->quote("%".ucfirst($q)."%");
  //      echo $que."<br>";
        $city=City::
            where(function($queryin)use ($que,$que2){
                    $queryin->orWhereRaw("JSON_SEARCH(namearray,\"all\" ,".$que.") IS NOT NULL ")->orWhereRaw("JSON_SEARCH(namearray,\"all\" ,".$que2.") IS NOT NULL ");
                })               
            //whereRaw("JSON_EXTRACT(namearray,'$') LIKE ".$que." ")
            ->get();


/*
        foreach ($data['category'] as $crow) {
         //   print_r($crow->subcategory->whereHas('productsubcat') );            
              // print_r($crow->subcategory->has('productsubcat') );

            foreach ($crow->subcategory as $subrow) {
            //    print_r($subrow->productsubcat);
              //  print_r($subrow->has('productsubcat'));
                 //echo $subrow->name."<br>";
                if(count($subrow->productsubcat )>0 ){
                //if($subrow->has('productsubcat')){
                   
                    echo $subrow->name."<br>";

                
                }
            }
        }*/
                
        $data['language']=Language::whereHas('productlanguage',function($query) use ($city){
                return $query->whereHas('product',function($query2) use ($city){
                    $query2->where(function($query3)use ($city){
                        foreach($city as $row){
                            $query3->orWhere('cityid',$row->id);
                        }
                        return $query3;
                    });
                    return $query2;
                });
            })->get();
        
        $productspart=Product::where('checkadmin',1)->where('remove',0);

        if($q!=NULL){
            $productspart->whereHas('city',function($query) use ($que,$que2){
                return $query->where(function($queryin)use ($que,$que2){
                    $queryin->orWhereRaw("JSON_SEARCH(namearray,\"all\" ,".$que.") IS NOT NULL ")->orWhereRaw("JSON_SEARCH(namearray,\"all\" ,".$que2.") IS NOT NULL ");
                });                
            });
        }
            /*
            ->where(function($query)use ($city){
                foreach($city as $row){
                    $query->orWhere('cityid',$row->id);
                }
                return $query;
            });*/
        if($data['qlanguage']!=NULL){
            $productspart->whereHas('language',function($querylang)use ($data){
                return $querylang->where('languageid',$data['qlanguage']);
            });
        }
        if($data['toursize']!=NULL && $data['toursize']!="all"){            
            $productspart->where('toursizeid',$data['toursize']);
        }
        if ($data['querycategory']!=NULL) {
            $productspart->whereHas('category',function($querycat)use ($data) {
                return $querycat->where('name',$data['querycategory']);
            });
        }
        if ($data['querysubcategory']!=NULL) {
            $productspart->whereHas('subcategory',function($querysubcat)use ($data){
                return $querysubcat->whereHas('category',function($query)use ($data){
                    return $query->where('name',$data['querysubcategory']);
                });
            });
        }
        if($data['time']!=NULL){
            switch ($data['time']) {
                case '0to2':
                    $productspart//->where('totalrequiredday',0)
                            ->where(function($query){
                                $query->orWhere('totalrequiredday',0)
                                ->orWhereNull('totalrequiredday');
                            })
                            ->where('totalrequiredhour','<=',2);                
                    break;
                case '2to4':
                    $productspart->where(function($query){
                                    $query->orWhere('totalrequiredday',0)
                                    ->orWhereNull('totalrequiredday');
                                })
                                ->where('totalrequiredhour','>',2)
                                ->where('totalrequiredhour','<=',4);                    
                    break;
                case '4to6':
                    $productspart->where(function($query){
                                    $query->orWhere('totalrequiredday',0)
                                    ->orWhereNull('totalrequiredday');
                                })                    
                                ->where('totalrequiredhour','>',4)
                                ->where('totalrequiredhour','<=',6);
                    break;
                case '6to':
                    $productspart
                                ->where(function($query){
                                    $query->orWhere('totalrequiredday','>',0)
                                    ->orWhere('totalrequiredhour','>',6);                                    
                                });
                    break;
                default:
                    # code...
                    break;
            }
        }
        if($data['meetingtime']!=NULL && $data['meetingtime']!="all"){
            switch ($data['meetingtime']) {
                case 'before 12':
                    $productspart->where('meetingtime','<','12:00');
                    break;
                case 'afternoon':
                    $productspart->where('meetingtime','>=','12:00')
                        ->where('meetingtime','<','18:00');
                    break;
                case 'evening':
                    $productspart->where('meetingtime','>=','18:00');
                    break;
                default:
                    # code...
                    break;
            }
        }

        if($data['grade']!=NULL && $data['grade']!='all' && is_numeric($data['grade']) && $data['grade']>0 && $data['grade']<=5){
            /*
            $productspart->whereHas('avgfeedback',function($querystat)use ($data){
                $querystat->where('star','>=',4);
                });     */
            //avgfeedback
    //        $productspart->with('avgfeedback');
            
/*
->addSelect(['last_login_at' => Login::select('created_at')
        ->whereColumn('user_id', 'users.id')
        ->latest()
        ->take(1)
    ])    ->withCasts(['last_login_at' => 'datetime'])
*/
/*
            $productspart->whereHas('feedbackstat',function($querystat)use ($data){
                    return $querystat->where('star','>=',$data['grade']);                
                });*/
                /*
            $productspart->whereHas('feedbackstat',function($querystat)use ($data){
                    return $querystat->where('avgstar','>=',5);                
                });*/
        }


        /* pages
         */
        $cloneproduct=clone $productspart;
        $maxrows=$cloneproduct->count();
        $data['pages']=intdiv($maxrows,$limit);
        if( $maxrows%$limit !=0){
            $data['pages']++;
        }
        $data['page']=$page;
        if($data['page']>$data['pages']){
            $data['page']=$data['pages'];
        }
        $offset=($data['page']-1)*$limit;
        /* pages end
         */
//DB::enableQueryLog(); 
        $data['products']=$productspart->offset($offset)
                ->limit($limit)
                ->get();
 //               dd(DB::getQueryLog()); 
        //$data['url']="?";
                /*
                        $data['q']=$req->q;
        $data['grade']=$req->grade;
        $data['toursize']=$req->toursize;
        $data['qlanguage']=$req->language;
        $data['time']=$req->time;
        $data['meetingtime']=$req->meetingtime;
        */
//        $logtoursize=TourSize::where('')
        LogSearch::create([
            'search'=>$req->q,
            'category'=>$data['querycategory'],
            'subcategory'=>$data['querysubcategory'],
            'countryid'=>NULL,
            'cityid'=>NULL,
            'minprice'=>NULL,
            'maxprice'=>NULL,
            'grade'=>$data['grade'],
            'toursize'=>$data['toursize'],
            'languageid'=>$data['qlanguage'],
            'time'=>$data['time'],
            'meetingtime'=>$data['meetingtime'],
            'sessionid'=>$sessionid,
            ]);

        $data['url']="q=".$data['q']."&grade=".$data['grade']."&toursize=".$data['toursize']."&language=".$data['qlanguage']."&time=".$data['time']."&meetingtime=".$data['meetingtime']."&category=".$data['querycategory']."&subcategory=".$data['querysubcategory'];

        $data['urlwithoutcategory']="q=".$data['q']."&grade=".$data['grade']."&toursize=".$data['toursize']."&language=".$data['qlanguage']."&time=".$data['time']."&meetingtime=".$data['meetingtime'];
      //  $data['']=TourSize::get();
        $data['toursize']=TourSize::get();
        return view('offers')->with('data',$data);
    }

    public function offersproduct($lang,$slug){
        $data['slug']=$slug;

        $data['product']=Product::where('checkadmin',1)
                ->where('title',$slug)
                ->where('remove',0)
                ->first();
        if($data['product']==NULL){
            return redirect('404');
        }        
        $sessionid=session()->getId();
        
        /*
        $ip=\Request::ip();      
        
        $country="";
        $state="";
        $city="";
        $referer="direct link";
        /*
        $ch=Log::where('ip',$ipaddress)->first();
        if($ch==NULL){
            */
            /*
            if(isset($req->ipinfo->country_name)){
                $country=$req->ipinfo->country_name;
            }
            if(isset($req->ipinfo->country)){
                $countrycode=$req->ipinfo->country;
            }
            if(isset($req->ipinfo->region)){
                $state=$req->ipinfo->region;
            }
            if(isset($req->ipinfo->city)){
                $city=$req->ipinfo->city;
            }
            /*
        }else{
            $country=$ch->country;
            $state=$ch->state;
            $city=$ch->city;        
        }*/
        
        LogViewProduct::create([
            'sessionid'=>$sessionid,
            'productid'=>$data['product']->id,
            'countryid'=>$data['product']->countryid,
            'cityid'=>$data['product']->cityid,
            'categoryid'=>$data['product']->categoryid,
            'toursizeid'=>$data['product']->toursizeid,
            'meetingtime'=>$data['product']->meetingtime,
            'totalrequiredday'=>$data['product']->totalreqday,
            'totalrequiredhour'=>$data['product']->totalreqhour,
            'totalrequiredminute'=>$data['product']->totalrequiredminute,
            'vehicleid'=>$data['product']->vehicleid,            
            ]);
        
        $data['tomorrow']=date('Y-m-d',strtotime('1 days'));
        return view('offersproduct')->with('data',$data);
    }
    public function offersproductbyid(Request $req){
        $validateDate=$req->validate([
            'id'=>'required|exists:product,id',
            ]);
        $data['product']=Product::where('checkadmin',1)
            ->where('id',$req->id)
            ->where('remove',0)
            ->first();
        if($data['product']==NULL){
            return redirect('404');
        }
        $data['tomorrow']=date('Y-m-d',strtotime('1 days'));
        return view('offersproduct')->with('data',$data);
    }


    public function partnersignup(){
        $data['p_list']=[
                'tourorticket',
                'bus',
                'hotel',
                'restaurant'];
        $data['country']=Country::get();
        return view('partner.signup')->with('data',$data);
    }
    public function postpartnersignup(Request $req){
        $validateDate=$req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'acceptgdpr'=>['required','string'],

            'country'=>'required|exists:App\Country,id',
            'city'=>'required|string',
            'category'=>'required|string',
            'companyName'=>'required|string',
            'postcode'=>'required|string',
            'address'=>'required|string',
            'taxNumber'=>'required|string',
            ]);
        $user=User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'countryid'=>$req->country,
            'city'=>$req->city,
            'company_name'=>$req->companyName,
            'postcode'=>$req->postcode,
            'address'=>$req->address,
            'tax_number'=>$req->taxNumber,
        ]);
      //  event(new Registered($user));
        $permission=PermissionName::where('perm_name','partner')->first();
        $busperm=PermissionName::where('perm_name','partner bus')->first();
        $ticketperm=PermissionName::where('perm_name','partner tour/ticket')->first();
        $hotelperm=PermissionName::where('perm_name','partner Hotel')->first();
        $restaurantperm=PermissionName::where('perm_name','partner Restaurant')->first();

       // Permission::create(['userid'=>$user->id,'permid'=>$permission->id]);
        if(strtolower($req->category)=='bus'){
            Permission::create(['userid'=>$user->id,'permid'=>$busperm->id]);
            $buscompany=BusCompany::create([
                    'name'=>$req->companyName,
                    'postcode'=>$req->postcode,
                    'address'=>$req->address,
                    'tax_number'=>$req->taxNumber,
                    'countryid'=>$req->country,
                    'city'=>$req->city,
                    ]);
            $buscompperm=BusCompanyPermission::create([
                    'userid'=>$user->id,
                    'bus_companyid'=>$buscompany->id,
                    ]);
        }
        if(strtolower($req->category)=="hotel"){
            Permission::create(['userid'=>$user->id,'permid'=>$hotelperm->id]);
            $hotelcomp=HotelCompany::create([
                    'name'=>$req->companyName,
                    'postcode'=>$req->postcode,
                    'address'=>$req->address,
                    'tax_number'=>$req->taxNumber,
                    'countryid'=>$req->country,
                    'city'=>$req->city,                
                ]);
            HotelCompanyPermission::create(['userid'=>$user->id,'hotel_companyid'=>$hotelcomp->id ]);
            Hotel::create([
                    'name'=>$req->companyName,
                    'city'=>$req->city,
                    'address'=>$req->address,
                    'countryid'=>$req->country,
                    'hotel_companyid'=>$hotelcomp->id,
                ]);
        }
        if(strtolower($req->category)=='restaurant'){
            Permission::create(['userid'=>$user->id,'permid'=>$restaurantperm->id]);
            $restaurantComp=RestaurantCompany::create([
                'name'=>$req->companyName,
                    'postcode'=>$req->postcode,
                    'address'=>$req->address,
                    'tax_number'=>$req->taxNumber,
                    'countryid'=>$req->country,
                    'city'=>$req->city,                
                ]);
            RestaurantCompanyPermission::create(['userid'=>$user->id,'restaurant_companyid'=>$restaurantComp->id]);
            Restaurant::create([
                    'name'=>$req->companyName,
                    'city'=>$req->city,
                    'address'=>$req->address,
                    'countryid'=>$req->country,
                    'restaurant_companyid'=>$restaurantComp->id,
                ]);
        }
        if(strtolower($req->category)=='tourorticket'){
            Permission::create(['userid'=>$user->id,'permid'=>$ticketperm->id]);
        }


        return redirect(route('login',app()->getLocale()) )->with('success',__('messages.registrationcomplete'));
    }
}
