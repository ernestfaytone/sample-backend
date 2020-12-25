<?php

namespace App\Http\Middleware;
use Closure;

class CORS {
    
    public function handle($request, Closure $next) {
        header('Acess-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        header('Acess-Control-Allow-Origin: Content-type, X-Auth-Token, Authorization, Origin');
        return $next($request);
    }

}
