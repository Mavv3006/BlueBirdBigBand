<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionToAccessAdminRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()->hasPermissionTo('route.access-admin')) {
            throw UnauthorizedException::forPermissions(['route.access-admin']);
        }

        return $next($request);
    }
}
