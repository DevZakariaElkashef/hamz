<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Store;
use App\Models\Section;
use App\Observers\OrderObserver;
use App\Observers\StoreObserver;
use App\Observers\SectionObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // View::composer('*', 'App\Http\ViewComposer\SettingComposer');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Model::shouldBeStrict(app()->isLocal());

        Paginator::useBootstrapFive();

        Order::observe(OrderObserver::class);
        Section::observe(SectionObserver::class);
        Store::observe(StoreObserver::class);
    }
}
