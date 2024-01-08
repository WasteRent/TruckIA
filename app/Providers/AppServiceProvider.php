<?php

namespace App\Providers;

use App\Classes\Distromel\DistromelClient;
use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\Moba\MobaClient;
use App\Classes\Odoo\OdooClient;
use App\Classes\TomTom\TomTomClient;
use App\Classes\WeMob\WeMobClient;
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

        $this->app->bind(OdooClient::class, function () {
            return new OdooClient(
                config('odoo.base_url'),
                config('odoo.account'),
                config('odoo.username'),
                config('odoo.password')
            );
        });

        $this->app->bind(MobaClient::class, function () {
            return new MobaClient(
                config('moba.base_url'),
                config('moba.username'),
                config('moba.password')
            );
        });

        $this->app->bind(DistromelClient::class, function () {
            return new DistromelClient(
                config('distromel.base_url'),
                config('distromel.username'),
                config('distromel.password'),
                config('distromel.key'),
            );
        });

        $this->app->bind(GeocodeClient::class, function () {
            return new GeocodeClient(config('googlemaps.api_key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('vendor.pagination.tailwind');
    }
}
