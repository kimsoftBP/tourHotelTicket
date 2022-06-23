<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;

use Auth;

class DashboardController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permadminorcontinentadmin');
    }
    
    public function index(Request $req){
        $user=Auth::user();
        $productspart=Product::whereRaw('1=1')
                ->where('page1',1)
                ->where('page2',1)
                ->where('page3',1)        
                ->where('remove',0);
        $page=$req->page;
        $limit=10;        
        if(!is_numeric($page) || $page<1){
            $page=1;
        }
        $data['page']=$page;
        //e

        if($req->language!=NULL){

        }
        if($req->country!=NULL){

        }
        if($req->city!=NULL){

        }
        //if($req->name!=NULL && is_string($req->name)){

        if(!$user->permadmin() ){
            if(!$user->permcontinentadmin()){
                $productspart->where(function($langquery) use($user){
                    $langquery->whereRaw('1!=1');//if foreach input null not have permission
                    foreach ($user->permissionLanguage as $row) {
                        $langquery->orWhereHas('language',function($lang) use($row){
                            $lang->where('languageid', $row->languageid);
                        });
                    }
                });
                $productspart->where(function($region) use($user){
                    $region->whereRaw('1!=1');//if foreach input null not have permission
                    foreach($user->permissionRegion as $row){
                        $region->orWhere('countryid',$row->countryid);
                    }
                });
            }else{
                /*continent admin limit region
                 */
                $productspart->where(function($region) use($user){
                    $region->whereRaw('1!=1');//if foreach input null not have permission
                    foreach($user->permissionRegion as $row){
                        $region->orWhereHas('country',function($country) use($row){
                            $country->whereHas('region',function($region)use ($row){
                                $region->where('continentid',$row->continentid);
                            });
                        });
                    }
                });
            }
        }

        
        //s
        $maxusers=clone $productspart;
        $maxrows=$maxusers->count();
        $data['pages']=intdiv($maxrows,$limit);
        if( $maxrows%$limit !=0){
            $data['pages']++;
        }
        if($page>$data['pages']){$data['page']=$data['pages'];}
        $offset=($data['page']-1)*$limit;
        //e 

        $data['country']=Product::whereNotNull('countryid')->groupBy('countryid')->get();
        $data['city']=Product::groupBy('cityid')->get();

        $data['url']="lang".$req->language."&country=".$req->country."&city=".$req->city;
        $data['products']=$productspart->orderBy('created_at','DESC')->limit($limit)->offset($offset)->get();

        return view('admin.dashboard')->with('data',$data);
    }
}
