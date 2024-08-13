<?php

namespace App\Http\Middleware;

use App\Enums\FeatureFlagName;
use App\Enums\StateMachines\FeatureFlagState;
use App\Services\FeatureFlag\FeatureFlagService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeatureFlagMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, string $flagName): Response
    {
        if (FeatureFlagService::getState(FeatureFlagName::from($flagName)) == FeatureFlagState::On) {
            return $next($request);
        }

        throw new NotFoundHttpException;
    }
}
