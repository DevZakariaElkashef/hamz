<?php

namespace App\Providers;

use App\Models\Store;
use App\Models\Section;
use App\Observers\StoreObserver;
use App\Observers\SectionObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('*', 'App\Http\ViewComposer\SettingComposer');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        Section::observe(SectionObserver::class);
        Store::observe(StoreObserver::class);
    }
}
