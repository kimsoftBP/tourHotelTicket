<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Authadmin
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
       // return $next($request);    

        $perm=0;                        
        if (Auth::user()!=NULL && ( Auth::user()->permadmin() || Auth::user()->permadminmenu() ) ) {
                return $next($request);    
        }        
        return redirect('/');     
    }
}
