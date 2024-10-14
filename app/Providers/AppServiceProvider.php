<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\AppSettingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AppSettingService::class, function ($app) {
            return new AppSettingService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
