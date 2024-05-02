<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $url): void
    {
        // if (env('APP_ENV') == 'production') {
        //     $url->forceScheme('https');
        // }

        Paginator::useBootstrap();

        $generalSetting = GeneralSetting::first();

        /** Set time zone */
        Config::set('app.timezone', $generalSetting->time_zone);

        /** share variable with Views */
        View::composer('*', function ($view) use ($generalSetting) {
            $view->with('settings', $generalSetting);
        });
    }
}
