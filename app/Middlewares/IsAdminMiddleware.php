<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminMiddleWare
{
    /**
     * Handle an incoming Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::guest() || !Auth::user()->isAdmin())
            return redirect('/', 301)->with('message', 'You need to be admin to see this page.');

        return $next($request);
    }
}
