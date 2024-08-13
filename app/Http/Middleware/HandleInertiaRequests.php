<?php

namespace App\Http\Middleware;

use App\Enums\FeatureFlagName;
use App\Enums\StateMachines\FeatureFlagState;
use App\Services\FeatureFlag\FeatureFlagService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'can' => [
                    'route.access-admin' => Gate::allows('route.access-admin'),
                    'route.access-intern' => Gate::allows('route.access-intern'),
                ],
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
            'feature_flags' => [
                'newsletter' => $this->checkFeatureFlag(FeatureFlagName::Newsletter),
            ],
        ]);
    }

    public function checkFeatureFlag(FeatureFlagName $flagName): bool
    {
        return FeatureFlagService::getState(FeatureFlagName::from($flagName->value)) == FeatureFlagState::On;
    }
}
