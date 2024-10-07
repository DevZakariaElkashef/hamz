<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            /** Begain Mall Routes */
            Route::middleware('api')
            ->prefix('mall/api')
            ->group(base_path('routes/mall/api.php'));

            Route::middleware('web')
            ->prefix('mall')
            ->group(base_path('routes/mall/web.php'));
            /** End Mall Routes */

            /** Begain Earn Routes */
            Route::middleware('api')
            ->prefix('earn/api')
            ->group(base_path('routes/earn/api.php'));

            Route::middleware('web')
            ->prefix('earn')
            ->group(base_path('routes/earn/web.php'));
            /** End Earn Routes */


        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
