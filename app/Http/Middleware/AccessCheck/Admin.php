<?php

namespace App\Http\Middleware\AccessCheck;

use Closure;
use Auth;

class Admin
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
        Auth::user()->authorizeRoles(['admin','programmer']);
            
        return $next($request);
    }
}
