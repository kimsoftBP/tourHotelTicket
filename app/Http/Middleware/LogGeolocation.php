<?php

namespace App\Http\Middleware;

use Closure;
use App\Log;
use Route;
//use Session;

class LogGeolocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
  //  public function terminate($request, $response)
    {        
        try {
            
        
                //print_r( $request->ipinfo->all );
                //echo $request->ipinfo->region;
            if($request->ipinfo!=NULL){
                    $ip=$request->ipinfo->ip;
                    $countrycode="";        
                    $country="";
                    $state="";
                    $city="";
                    $referer="direct link";

                    $sessionid=session()->getId();
                    
                    //return $next($request);



                   // echo $request->session()->getId();
                    $ch=Log::where('ip',$ip)->first();
                    if($ch==NULL){
                        if(isset($request->ipinfo->country_name)){
                            $country=$request->ipinfo->country_name;
                        }
                        if(isset($request->ipinfo->country)){
                            $countrycode=$request->ipinfo->country;
                        }
                        if(isset($request->ipinfo->region)){
                            $state=$request->ipinfo->region;
                        }
                        if(isset($request->ipinfo->city)){
                            $city=$request->ipinfo->city;
                        }

                    }else{
                        $country=$ch->country;
                        $countrycode=$ch->countrycode;
                        $state=$ch->state;
                        $city=$ch->city;        
                    }
                    if(isset($_SERVER['HTTP_REFERER'])) {
                        $referer=$_SERVER['HTTP_REFERER'];
                    }    
                    
                    Log::create([
                        'url'=>$request->url(),
                        'routename'=>$request->path(),
                        'sessionid'=>$sessionid,
                        'ip'=>$ip,
                        'country'=>$country,
                        'countrycode'=>$countrycode,
                        'state'=>$state,
                        'city'=>$city,
                        'referer'=>$referer
                        ]);
                //return 0;
            }
        } catch (Exception $e) {
            
        }
        return $next($request);
    }
}
