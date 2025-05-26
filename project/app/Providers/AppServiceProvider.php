<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\TokenServiceInterface;
use App\Services\PassportTokenService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(\App\Http\Controllers\Auth\EmployeeController::class)
            ->needs(\App\Services\Contracts\AuthServiceInterface::class)
            ->give(\App\Services\Auth\EmployeeAuthService::class);

        $this->app->when(\App\Http\Controllers\Auth\AdministratorController::class)
            ->needs(\App\Services\Contracts\AuthServiceInterface::class)
            ->give(\App\Services\Auth\AdministratorAuthService::class);

        $this->app->bind(TokenServiceInterface::class, PassportTokenService::class);

        $this->app->bind(
            \App\Services\Address\Contracts\ViaCepServiceInterface::class,
            \App\Services\Address\ViaCepService::class
        );

        $this->app->bind(
            \App\Services\Employee\Contracts\EmployeeServiceInterface::class,
            \App\Services\Employee\EmployeeService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
