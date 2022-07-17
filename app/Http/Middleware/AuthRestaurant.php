<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AuthRestaurant
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
        if (Auth::user()!=NULL &&  Auth::user()->permPartnerRestaurant()) {
                return $next($request);    
        }        
        return redirect('/');     
    }
}
