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
    public const HOME = '/';

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

            /** Begain Booth Routes */
            Route::middleware('api')
                ->prefix('booth/api')
                ->group(base_path('routes/booth/api.php'));

            Route::middleware('web')
                ->prefix('booth')
                ->group(base_path('routes/booth/web.php'));
            /** End Booth Routes */

            /** Begain used_market Routes */
            Route::middleware('api')
                ->prefix('usedMarket/api')
                ->group(base_path('routes/usedMarket/api.php'));

            Route::middleware('web')
                ->prefix('usedMarket')
                ->group(base_path('routes/usedMarket/web.php'));
            /** End used_market Routes */

            /** Begain rfoof Routes */
            Route::middleware('api')
                ->prefix('rfoof/api')
                ->group(base_path('routes/rfoof/api.php'));

            Route::middleware('web')
                ->prefix('rfoof')
                ->group(base_path('routes/rfoof/web.php'));
            /** End rfoof Routes */

            /** Begain Earn Routes */
            Route::middleware('api')
                ->prefix('earn/api')
                ->group(base_path('routes/earn/api.php'));

            Route::middleware('web')
                ->prefix('earn')
                ->group(base_path('routes/earn/web.php'));
            /** End Earn Routes */

            /** Begain Coupons Routes */
            Route::middleware('api')
                ->prefix('coupons/api')
                ->group(base_path('routes/coupons/api.php'));

            Route::middleware('web')
                ->prefix('coupons')
                ->group(base_path('routes/coupons/web.php'));
            /** End Coupons Routes */

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
