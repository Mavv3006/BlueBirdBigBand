<?php

namespace App\Providers;

use App\DataTransferObjects\View\InertiaMetaInfoDto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(InertiaMetaInfoDto::class, fn () => new InertiaMetaInfoDto());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(125);

        Model::shouldBeStrict(!App::isProduction());
    }
}
