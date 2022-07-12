<?php

namespace App\Classes\GoogleMaps;

use Illuminate\Support\Facades\Http;

class GeocodeClient
{
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function reverseGeocode(string $latitude, string $longitude)
    {
        $data = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "{$latitude},{$longitude}",
            'language' => 'es',
            'key' => $this->apiKey,
        ])->json();

        if (isset($data['results']) &&
            isset($data['results'][0]) &&
            isset($data['results'][0]['formatted_address'])
        ) {
            return $data['results'][0]['formatted_address'];
        }

        return null;
    }
}
