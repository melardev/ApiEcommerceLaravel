<?php

namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
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
        // return $next($request)
        // ->header('Access-Control-Allow-Origin', '*')
        // ->header('Access-Control-Allow-Methods', '*')
        // ->header('Access-Control-Allow-Credentials', true)
        // ->header('Access-Control-Allow-Headers', 'X-Requested-With,Content-Type,X-Token-Auth,Authorization')
        // ->header('Accept', 'application/json');
        // $domain = parse_url($_SERVER['HTTP_REFERER']);
        $host = '*';
        // if (isset($domain['host'])) {
        //     $host = $domain['host'];
        // }
        return $next($request)
        ->header('Access-Control-Allow-Origin', $host)
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        }
}