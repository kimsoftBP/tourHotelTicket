<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AuthBus
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
        if (Auth::user()!=NULL &&  Auth::user()->permPartnerBus()) {
                return $next($request);    
        }        
        return redirect('/');     
    }
}
