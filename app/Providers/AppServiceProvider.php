<?php

namespace App\Providers;

use App\Services\KonzertmeisterIntegration\ICalAdapter;
use App\Services\KonzertmeisterIntegration\ICalInterface;
use App\Services\KonzertmeisterIntegration\ICalMockAdapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);

        Model::shouldBeStrict(!App::isProduction());

        if ($this->app->runningUnitTests()) {
            $this->app->bind(ICalInterface::class, ICalMockAdapter::class);
        } else {
            $this->app->bind(ICalInterface::class, ICalAdapter::class);
        }
    }
}
