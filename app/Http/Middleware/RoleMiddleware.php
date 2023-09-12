<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        if (! auth()->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        $parsedRoles = explode(',', $roles);

        if (! auth()->user()->roles()->whereIn('name', $parsedRoles)->exists()) {
            abort(403, "You don't have enough permission to access this resource");
        }

        return $next($request);
    }
}
