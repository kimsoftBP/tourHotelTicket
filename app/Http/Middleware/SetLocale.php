<?php

namespace App\Http\Middleware;

use Closure;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang=env('DEFAULT_LOCAL','en');        
        $true=0;
        $list=env('AVAILABLE_LOCAL', 'en');
        $exp=explode(',',$list);
        foreach ($exp as $row) {
            if($request->segment(1)==$row){
                $true=1;
                $lang=$request->segment(1);
                //echo $lang."true";
            }            
        }
        if($true==1){
            $lang==$request->segment(1);
        }
        
        app()->setLocale($lang);
        return $next($request);
    }
}
