<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Modules\Search\Models\SearchFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //laravel-cross-eloquent-search
        $this->app->singleton('laravel-search', function () {
            return new SearchFactory;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom('app/Modules/**/*');
        Paginator::useBootstrap();
    }
}
