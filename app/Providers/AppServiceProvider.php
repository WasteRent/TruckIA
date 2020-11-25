<?php

namespace App\Providers;

use App\Classes\TomTom\TomTomClient;
use App\Classes\WeMob\WeMobClient;
use Carbon\Carbon;
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
        $this->app->bind(TomTomClient::class, function () {
            return new TomTomClient(
                config('tomtom.base_url'),
                config('tomtom.api_key'),
                config('tomtom.account'),
                config('tomtom.username'),
                config('tomtom.password')
            );
        });

        $this->app->bind(WeMobClient::class, function () {
            return new WeMobClient(
                config('wemob.base_url'),
                config('wemob.username'),
                config('wemob.password')
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
