<?php

namespace App\Providers;

use App\Services\GuaranteeService;
use App\Services\LoanService;
use App\Services\RefereeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LoanService::class, function ($app) {
            return new LoanService($app->make(RefereeService::class));
        });

        $this->app->singleton(RefereeService::class, function ($app) {
            return new RefereeService();
        });

        $this->app->singleton(GuaranteeService::class, function ($app) {
            return new GuaranteeService();
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
