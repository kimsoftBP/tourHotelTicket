<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AuthTourTicket
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
        if (Auth::user()!=NULL &&  Auth::user()->permPartnerTicketOrTour()) {
                return $next($request);    
        }        
        return redirect('/');     
    }
}
