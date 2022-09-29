<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PermAdminOrPermContinentAdmin
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
        $perm=0;                        
        if (Auth::user()!=NULL && ( Auth::user()->permadmin() || Auth::user()->permcontinentadmin() ) ) {
                return $next($request);    
        }        
        return redirect('/');     
    }
}
