<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\MetaInfo;

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
    public function boot(): void
    {
        if (env('FORCE_HTTPS', false)) {
            error_log('configuring https');

            $app_url = config("app.url");
            URL::forceRootUrl($app_url);
            $schema = explode(':', $app_url)[0];
            URL::forceScheme($schema);
        }
        View::composer('layouts.app', function ($view) {
            $metaInfos = MetaInfo::all();
            $view->with('metaInfos', $metaInfos);
        });
    }
}
