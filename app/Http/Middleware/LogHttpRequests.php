<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogHttpRequests
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Request logged', [
            'url' => $request->url(),
            'method' => $request->method(),
            'headers' => $request->headers->all(),
        ]);

        Log::debug('Request data', ['data' => $request->except('password')]);

        return $next($request);
    }
}
