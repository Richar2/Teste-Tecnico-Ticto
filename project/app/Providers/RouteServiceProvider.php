<?php
namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
   
        $this->configureRateLimiting();
        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
        });
    }

    protected function mapApiRoutes()
    {
     
          
        $files = File::allFiles(base_path('routes/api'));
        foreach ($files as $file) {
            Route::prefix('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api/' . $file->getFilename()));
        }
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')->namespace($this->namespace)->group(base_path('routes/web.php'));
    }
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
