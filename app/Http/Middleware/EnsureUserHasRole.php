<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $u = $request->user();
        abort_unless($u && in_array($u->role, $roles), 403);
        return $next($request);
    }
}
