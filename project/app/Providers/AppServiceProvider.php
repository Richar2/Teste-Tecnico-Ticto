<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Contracts\TokenServiceInterface;
use App\Services\Auth\EmployeeAuthService;
use App\Services\PassportTokenService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(\App\Http\Controllers\Auth\EmployeeController::class)
                  ->needs(AuthServiceInterface::class)
                  ->give(EmployeeAuthService::class);

        $this->app->bind(TokenServiceInterface::class, PassportTokenService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
