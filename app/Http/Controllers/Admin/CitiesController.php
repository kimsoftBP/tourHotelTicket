<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Continent;
use App\Country;
use App\Region;
use App\City;
use App\CityImages;

use Auth;

class CitiesController extends Controller
{
    public function __construct(){
        $this->middleware('permadminorcontinentadmin');
    }
    //
    public function index(Request $req){
        $page=$req->page;
        $limit=15;
        if(!is_numeric($page) || $page<1){
            $page=1;
        }
        $data['page']=$page;

        $user=Auth::user();
    	$data['continent']=Continent::get();    	
    	$citiespart=City::whereRaw('1=1');
    	$country=$req->country;
    	$continent=$req->continent;
    	$region=$req->region;
    	if($req->country!=NULL && $req->country!=""){
    		$citiespart->whereHas('country', function ($query)use ($country) {
			    return $query->where('name', '=', $country);
			});
    	}elseif($region!=NULL && $region!=""){
    		$citiespart->whereHas('country', function ($query)use ($region) {
    			return $query->whereHas('region', function ($query2)use ($region) {
			    	return $query2->where('name', '=', $region);
			    });
			});	
    	}elseif($req->continent!=NULL && $req->continent!=""){    		
    		$citiespart->whereHas('country', function ($query)use ($continent) {
    			return $query->whereHas('region', function ($query2)use ($continent) {
    				return $query2->whereHas('continent', function ($query3)use ($continent) {
    					return $query3->where('name', '=', $continent);
    				});
			    });
			});	
    	}

        /**
         *
         **/
        if(!$user->permadmin() ){
            if(!$user->permcontinentadmin()){
                //moderator
                $citiespart->where(function($region) use($user){
                    $region->whereRaw('1!=1');//if foreach input null not have permission
                    foreach($user->permissionRegion as $row){
                        $region->orWhere('countryid',$row->countryid);
                    }
                });
            }else{
                $citiespart->whereHas('country', function ($query)use ($user) {
                    return $query->whereHas('region', function ($query2)use ($user) {
                        $query2->whereRaw('1!=1');
                        foreach($user->permissionRegion as $row){
                            $query2->orWhere('continentid',$row->continentid);
                        }
                    });
                }); 
            }

        }
        /**
         *
         **/

    	$data['searchcontinent']=$continent;
    	$cont=Continent::where('name',$continent)->first();
    	$data['searchregion']=$region;
    	$data['region']="";
    	if($cont!=NULL){
    		$data['region']=Region::where('continentid',$cont->id)->get();
    	}
    	$data['searchcountry']=$country;
    	$getregion=Region::where('name',$region)->first();
    	$data['country']="";
    	if($getregion!=NULL){
    		$data['country']=Country::where('regionid',$getregion->id)->get();
    	}

        $maxusers=clone $citiespart;
        $maxrows=$maxusers->count();
        $data['pages']=intdiv($maxrows,$limit);
        if( $maxrows%$limit !=0){
            $data['pages']++;
        }
        if($page>$data['pages']){$data['page']=$data['pages'];}
        $offset=($data['page']-1)*$limit;

        $data['url']="continent=".$req->continent."&region=".$req->region."&country=".$req->country;
    	$data['cities']=$citiespart->orderBy('name')->limit($limit)->offset($offset)->get();


    	return view('admin.cities')->with('data',$data);
    }
    public function add(Request $req){
    	$validateDate=$req->validate([
    		'continent'=>'required|exists:continents,name',
    		'region'=>'required|exists:regions,name',
    		'country'=>'required|exists:country,name',
    		'city'=>'required|string|unique:city,name',
    		'image'=>'image|mimes:jpeg,jpg,png,webp',    		
    		'imagesmall'=>'image|mimes:jpeg,jpg,png,webp',
    	]);
    	$data['continent']=$req->continent;
    	$data['region']=$req->region;   
        $user=Auth::user();


    	$country=Country::where('name',$req->country)
    		->whereHas('region', function ($query2)use ($data) {
    			return $query2->whereHas('continent', function ($query3)use ($data){
							return $query3->where('name', '=', $data['continent']);
		    			})
    					->where('name',$data['region']);
    		})->first();
    	if($country==NULL){//no country
    		return redirect()->back()->with('error', 'Error');   
    	}

         /**
         *
         **/
        if(!$user->permadmin() ){
            $access=0;
            if(!$user->permcontinentadmin()){
                foreach($user->permissionRegion as $row){
                    if($country->id==$row->countryid){
                        $access=1;
                    }
                }
            }else{
                $continent=$country->region->continentid;
                foreach($user->permissionRegion as $row){
                    if($continent==$row->continentid){
                        $access=1;
                    }
                }
            }
            if($access==0){
                return redirect()->back()->with('error', 'You do not have permission to access this region');  
            }
        }
        /**
         *
         **/

		$city=City::create(['name'=>$req->city,
			'countryid'=>$country->id]);		
		$path=$data['continent']."/".$data['region']."/".$country->name;
		$extension="";
    	$fileNameToStore="";
    	if ($req->hasFile('image')) {
            $filenameWithExt = $req->file('image')->getClientOriginalName();
            $extension = $req->file('image')->getClientOriginalExtension();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $now=now();            
            $fileNameToStore=$city->name.'.'.$extension;
            $req->image->move(public_path('image/'.$path), $fileNameToStore);
             CityImages::create([
            'name'=>$fileNameToStore,
            'folder'=>'/image/'.$path,
            'extension'=>$extension,
            'cityid'=>$city->id,
            'notes'=>'cover',
            ]);
        }
        $extension="";
    	$fileNameToStore="";
    	if ($req->hasFile('imagesmall')) {
            $filenameWithExt = $req->file('imagesmall')->getClientOriginalName();
            $extension = $req->file('imagesmall')->getClientOriginalExtension();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $now=now();
            $fileNameToStore=$city->name.'small.'.$extension;
            $req->imagesmall->move(public_path('image/'.$path), $fileNameToStore);
            CityImages::create([
            'name'=>$fileNameToStore,
            'folder'=>'/image/'.$path,
            'extension'=>$extension,
            'cityid'=>$city->id,
            'notes'=>'small',
            ]);
        }
        return redirect()->back()->with('success', 'Save complete');   
    }
    public function edit(Request $req){
        $validateDate=$req->validate(['city'=>'exists:city,id']);
        $data['city']=City::where('id',$req->city)->first();
        $data['searchcountry']=$data['city']->country->name;
        $data['country']=Country::where('regionid',$data['city']->country->regionid)->get();
        $regio=Region::where('id',$data['city']->country->regionid)->first();
        $data['searchregion']=$regio->name;
        $data['region']=Region::where('continentid',$regio->continentid)->get();
        $data['continent']=Continent::get();
        $data['searchcontinent']=$data['city']->country->region->continent->name;

        $user=Auth::user();
        /**
         *
         **/
        $city=$data['city'];
        if(!$user->permadmin() ){
            $access=0;
            if(!$user->permcontinentadmin()){
                foreach($user->permissionRegion as $row){
                    if($city->country->id==$row->countryid){
                        $access=1;
                    }
                }
            }else{
                $continent=$city->country->region->continentid;
                foreach($user->permissionRegion as $row){
                    if($continent==$row->continentid){
                        $access=1;
                    }
                }
            }
            if($access==0){
                return redirect(404);
             //   return redirect()->back()->with('error', 'You do not have permission to access this region');  
            }
        }
        /**
         *
         **/
        return view('admin.editcity')->with('data',$data);
    }
    public function postedit(Request $req){
        $validateDate=$req->validate([
            'cityid'=>'required|exists:city,id',
            'continent'=>'required|exists:continents,name',
            'region'=>'required|exists:regions,name',
            'country'=>'required|exists:country,name',
            'city'=>'required|string',
            'image'=>'image|mimes:jpeg,jpg,png,webp',           
            'imagesmall'=>'image|mimes:jpeg,jpg,png,webp',
        ]);
        $data['continent']=$req->continent;
        $data['region']=$req->region;   
        $user=Auth::user();

        $country=Country::where('name',$req->country)
            ->whereHas('region', function ($query2)use ($data) {
                return $query2->whereHas('continent', function ($query3)use ($data){
                            return $query3->where('name', '=', $data['continent']);
                        })
                        ->where('name',$data['region']);
            })->first();
        if($country==NULL){//no country
            return redirect()->back()->with('error', 'Error');   
        }
        $checkalredyhavethiscityname=City::where('id','!=',$req->cityid)->where('name',$req->city)->first();
        if($checkalredyhavethiscityname!=NULL){
            return redirect()->back()->with('error', 'This city name already have');   
        }
        $city=City::where('id',$req->cityid)->first();


        /**
         *
         **/
        if(!$user->permadmin() ){
            $access=0;//new region
            $access2=0;//old region
            if(!$user->permcontinentadmin()){
                foreach($user->permissionRegion as $row){
                    if($country->id==$row->countryid){
                        $access=1;
                    }
                    if($city->country->ic==$row->countryid){
                        $access2=1;
                    }
                }
            }else{
                $continent=$country->region->continentid;
                $continent2=$city->country->region->continentid;
                foreach($user->permissionRegion as $row){
                    if($continent==$row->continentid){
                        $access=1;
                    }
                    if($continent2==$row->continentid){
                        $access2=1;
                    }
                }
            }
            if($access==0 || $access2==0){
                return redirect()->back()->with('error', 'You do not have permission to access this region');  
            }
        }
        /**
         *
         **/



        $city->name=$req->city;
        $city->countryid=$country->id;
   //     $names=['en'=>'Budapest_en','ko'=>'Budapest_ko'];
   //     $city->namearray=json_encode($names);
        $city->save();        
        foreach($city->photos as $row){            
            if($req["d".$row->id]==true){          
                $row->delete();                
            }
        }
        $path=$data['continent']."/".$data['region']."/".$country->name;
        $extension="";
        $fileNameToStore="";
        if ($req->hasFile('image')) {
            $filenameWithExt = $req->file('image')->getClientOriginalName();
            $extension = $req->file('image')->getClientOriginalExtension();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $now=now();            
            $fileNameToStore=$city->name.'.'.$extension;           
            $req->image->move(public_path('image/'.$path), $fileNameToStore);
            CityImages::create([
            'name'=>$fileNameToStore,
            'folder'=>'/image/'.$path,
            'extension'=>$extension,
            'cityid'=>$city->id,
            'notes'=>'cover',
            ]);
        }
        $extension="";
        $fileNameToStore="";
        if ($req->hasFile('imagesmall')) {
            $filenameWithExt = $req->file('imagesmall')->getClientOriginalName();
            $extension = $req->file('imagesmall')->getClientOriginalExtension();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $now=now();            
            $fileNameToStore=$city->name.'small.'.$extension;
            $req->imagesmall->move(public_path('image/'.$path), $fileNameToStore);
            CityImages::create([
            'name'=>$fileNameToStore,
            'folder'=>'/image/'.$path,
            'extension'=>$extension,
            'cityid'=>$city->id,
            'notes'=>'small',
            ]);
        }
        return redirect()->back()->with('success', 'Save complete');   
    }
    public function delete(Request $req){
        $validateDate=$req->validate(['city'=>'required|exists:city,id']);
        $city=City::where('id',$req->city)->delete();
        if($city==1){
            return redirect()->back()->with('success', 'Delete complete');   
        }else{
            return redirect()->back()->with('error', 'Error');   
        }
    }
}
