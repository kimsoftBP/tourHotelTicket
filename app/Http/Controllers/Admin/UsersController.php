<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Language;
use App\Country;
use App\Continent;
use App\PermissionName;
use App\Permission;
use App\PermissionRegion;
use App\PermissionLanguage;
use Illuminate\Support\Facades\Hash;

use Auth;

class UsersController extends Controller
{
    //
    public function __construct(){
        $this->middleware('permadminorcontinentadmin');
    }
    
    public function users(Request $req){
        $user=Auth::user();

        if(!$user->permadmin() ){
            if($user->permcontinentadmin() ){

            }
        }        
        $orderby="email";
        $orderbysorted="ASC";
        $orderbysortedinv="DESC";
        if($req->orderby=="name" || $req->orderby=="email" || $req->orderby=="created_at"){
            $orderby=$req->orderby;
        }
        if($req->orderbysorted=="ASC" || $req->orderbysorted=="DESC"){
            $orderbysorted=$req->orderbysorted;
        }
        if($orderbysorted=="ASC"){$orderbysortedinv="DESC";}else{$orderbysortedinv="ASC";}


    	$userspart=User::whereRaw('1=1');
        $page=$req->page;
        
    	$limit=20;    	

    	if(!is_numeric($page) || $page<1){
    		$page=1;
    	}
        $data['page']=$page;


    	if($req->name!=NULL && is_string($req->name)){
    		$userspart->where('name',$req->name);
    	}
    	if($req->email!=NULL && is_string($req->email)){
    		$userspart->where('email',$req->email);
    	}
        if($req->lang!=NULL ){
            $templang=Language::where('name',$req->lang)->first();
            if($templang!=NULL){

            }
        }
        if($req->country!=NULL ){
            $tempcountry=Country::where('name',$req->country)->first();
            if($tempcountry!=NULL){
                $userspart->where('countryid',$tempcountry->id);
            }
        }
        if($req->city!=NULL){
            $userspart->where('city',$req->city);
        }


    	$maxusers=clone $userspart;
    	$maxrows=$maxusers->count();
    	$data['pages']=intdiv($maxrows,$limit);
    	if( $maxrows%$limit !=0){
    		$data['pages']++;
    	}
        if($page>$data['pages']){$data['page']=$data['pages'];}
    	$offset=($data['page']-1)*$limit;

        $data['orderby']=$orderby;
        $data['orderbysorted']=$orderbysorted;
        $data['orderbysortedinv']=$orderbysortedinv;
        $data['allcountry']=Country::get();
        $data['url']="lang".$req->lang."&country=".$req->country."&city=".$req->city."&orderby=".$orderby."&orderbysorted=".$orderbysorted;
        $data['country']=User::groupBy('countryid')->get();
        //$data['city']=User::groupBy('cityid')->get();
        $data['language']=Language::get();
        $data['city']=User::where('city','!=','')->whereNotNull('city')->groupBy('city')->get();

    	$data['users']=$userspart->orderBy($orderby, $orderbysorted)->limit($limit)->offset($offset)->get();
    	return view('admin.users')->with('data',$data);
    }
    public function addnewuser(Request  $req){
        $validateDate=$req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country'=>'required|exists:country,id',
            'city'=>'required|string',
        ]);
        //$country=Country::where('')
        User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'countryid'=>$req->country,
            'city'=>$req->city,
        ]);
        return redirect()->back()->with('success','Create complete');
    }

    public function edituser(Request $req){
        $validateDate=$req->validate([
            'user'=>'required|exists:users,id',
        ]);
        $data['country']=Country::get();
        $data['permissions']=NULL;//PermissionName::get();
        $user=Auth::user();
        if(!$user->permadmin() ){
            if($user->permcontinentadmin() ){
                $data['permissions']=PermissionName::where('perm_name','partner')
                    ->orwhere('perm_name','moderator')->get();
            }
        }else{
            $data['permissions']=PermissionName::get();
        }
        $data['continents']=Continent::get();
        $data['country']=Country::get();
        $data['lang']=Language::get();

        $data['user']=User::where('id',$req->user)->first();

       // print_r($data['user']->permissionLanguage );
        //print_r($data['user']->permissionLanguage()->get() );
        //print_r($data['user']->permissionRegion()->get());
        return view('admin.edituser')->with('data',$data)->with('user',$data['user']);
    }
    public function postedituser(Request $req){
        $validateDate=$req->validate([
            'name' => ['required', 'string', 'max:255'],
            'phonenumber'=>'nullable|string',
            'country'=>'nullable|exists:country,id',
            'city'=>'nullable|string',
            'addpermission.*'=>'',
            'addcontinent.*'=>'',
            'addcountry.*'=>'',
            'addlanguage.*'=>'',
            'user'=>'required|exists:users,id',
        ]);
        $chuser=Auth::user();
        $now=now();

        $user=User::where('id',$req->user)->first();
        $user->name=$req->name;
        $user->phonenumber=$req->phonenumber;
        $user->countryid=$req->country;
        $user->city=$req->city;
        $user->save();

        //addpermission[]        
        $permadmin=PermissionName::where('perm_name','admin')->first();
        $permcontinentadmin=PermissionName::where('perm_name','continent admin')->first();
        if($chuser->permadmin() || $chuser->permcontinentadmin() ){
            if($req->addpermission!=NULL){
                foreach($req->addpermission as $row){                    
                    if( !(($chuser->permcontinentadmin() && !$chuser->permadmin() ) && ($row==$permadmin->id || $row==$permcontinentadmin->id) ) ){
                        Permission::updateOrCreate([
                            'userid'=>$user->id,
                            'permid'=>$row],['updated_at'=>$now]);
                    }
                }
            }
            //csak continent admin jogosultsaggal ne tudja torolni az admin es continent admin jogokat
            if($chuser->permcontinentadmin()&& !$chuser->permadmin()){
                Permission::where('userid',$user->id)
                    ->where('permid',$permadmin->id)
                    ->update(['updated_at'=>$now]);
                Permission::where('userid',$user->id)
                    ->where('permid',$permcontinentadmin->id)
                    ->update(['updated_at'=>$now]);
            }

            Permission::where('userid',$user->id)->where('updated_at','<',$now)->delete();
        }
        if($user->permcontinentadmin() ){            
            if($req->addcontinent!=NULL){
                foreach($req->addcontinent as $row){                
                    PermissionRegion::updateOrCreate([
                        'userid'=>$user->id,
                        'continentid'=>$row,
                        'countryid'=>NULL,
                        ],[
                        'addedbyuserid'=>$chuser->id,
                        'updated_at'=>$now,
                        ]
                        );
                }            
            }
        }
        if($user->permmoderator()){
            if($req->addcountry!=NULL){
                foreach($req->addcountry as $row){
                    PermissionRegion::updateOrCreate([
                        'userid'=>$user->id,
                        'continentid'=>NULL,
                        'countryid'=>$row,
                    ],[
                        'addedbyuserid'=>$chuser->id,
                        'updated_at'=>$now,
                    ]);
                }
            }
            if($req->addlanguage!=NULL){
                foreach($req->addlanguage as $row){
                    PermissionLanguage::updateOrCreate([
                        'userid'=>$user->id,
                        'languageid'=>$row,
                    ],[
                        'addedbyuserid'=>$chuser->id,
                        'updated_at'=>$now,
                    ]);
                }            
            }
        }
        PermissionLanguage::where('userid',$user->id)->where('updated_at','<',$now)->delete();

        PermissionRegion::where('userid',$user->id)->where('updated_at','<',$now)->delete();
        return redirect()->back()->with('success','Save compelete');
    }
}
