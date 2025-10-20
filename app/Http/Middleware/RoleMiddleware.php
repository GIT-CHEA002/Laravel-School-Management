<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $roles = func_get_args();
        // func_get_args returns: [request, next, role1, role2, ...]
        $roles = array_slice($roles, 2);

        if (! $request->user()) {
            abort(403);
        }

        if (! empty($roles) && ! in_array($request->user()->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
