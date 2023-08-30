<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class HasPermissionToAccessInternalRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, \Closure $next): Response
    {
        if (!Auth::user()->hasPermissionTo('route.access-intern')) {
            throw UnauthorizedException::forPermissions(['route.access-intern']);
        }

        return $next($request);
    }
}
