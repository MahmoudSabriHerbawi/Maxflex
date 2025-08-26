<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        // For prevent if the client forget to set Accept: application/json
        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
