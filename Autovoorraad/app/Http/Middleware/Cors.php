<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', 'http://Autovoorraad.127.0.0.1.nip.io');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, X-CSRF-Token, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true');

        // Handle preflight requests
        if ($request->getMethod() === "OPTIONS") {
            $response->setStatusCode(200);
            return $response;
        }

        return $response;
    }
}
