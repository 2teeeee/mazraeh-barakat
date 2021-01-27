<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redirect;
use Auth;

class CheckInfoUser
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
        if(!Auth::guest())
        {
         
            if(Auth::user()->status == 0 or Auth::user()->city_id == '')
                return Redirect::to('profile/checkInfo.html');
        }
        else
        {
            return Redirect::to('login');
        }
        return $next($request);
    }
}
