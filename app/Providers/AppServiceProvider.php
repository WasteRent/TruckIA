<?php

namespace App\Providers;

use App\Classes\Moba\MobaClient;
use App\Classes\Odoo\OdooClient;
use App\Services\WhatsAppService;
use App\Classes\TomTom\TomTomClient;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\Distromel\DistromelClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OdooClient::class, function () {
            return new OdooClient(
                config('odoo.base_url'),
                config('odoo.account'),
                config('odoo.username'),
                config('odoo.password')
            );
        });

        $this->app->bind(GeocodeClient::class, function () {
            return new GeocodeClient(config('googlemaps.api_key'));
        });

        $this->app->bind(WhatsAppService::class, function () {
            return new WhatsAppService(
                config('services.whatsapp.token'),
                config('services.whatsapp.phone_id')
            );
        });

        $this->app->bind(\OpenAI::class, function () {
            return \OpenAI::factory()
                ->withApiKey(config('services.openai.key'))
                ->withHttpClient(new \GuzzleHttp\Client(['timeout' => 240]))
                ->make();
            //return \OpenAI::client(config('services.openai.key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        Paginator::defaultView('vendor.pagination.tailwind');
    }
}
