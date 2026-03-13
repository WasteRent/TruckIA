<?php

namespace App\Services\VehicleTracking;

use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\Moba\MobaClient;
use App\Models\Vehicle;

class VehicleTrackingMobaService implements VehicleTrackingServiceInterface
{
    public function getDataByPlate(string $plate) : array
    {
        $normalized_plate = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $plate));

        $rows = [];
        foreach ($this->getAvailableServiceKeys() as $service_key) {
            $service_rows = $this->getDataForService($service_key, ['plate' => $normalized_plate]);
            $rows = array_merge($rows, $service_rows);
        }

        return $rows;
    }

    public function getDataForService(string $service_key, array $filters = []) : array
    {
        $base = config("services.moba.{$service_key}.base_url");
        $username = config("services.moba.{$service_key}.username");
        $password = config("services.moba.{$service_key}.password");

        if (! $base || ! $username || ! $password) {
            return [];
        }

        $moba = new MobaClient(
            $base,
            $username,
            $password,
        );

        $maps = app(GeocodeClient::class);

        // A diferencia del comando, aquí no recorremos vehículos de BD;
        // filtraremos por matrícula si se pasa en $filters.
        $vehicles = Vehicle::where('fleet_id', 30)->get();

        $rows = [];

        foreach ($vehicles as $vehicle) {
            $plate_normalized = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $vehicle->plate));

            if (isset($filters['plate']) && $filters['plate']) {
                if ($plate_normalized !== $filters['plate']) {
                    continue;
                }
            }

            $kms = 0;
            $hours = 0;
            $lat = 0;
            $lng = 0;
            $address = '';
            $fechaHora = null;

            try {
                $kms_data = $moba->getKms(
                    $vehicle->plate,
                    now()->subDays(10)->format('d/m/Y H:i:00'),
                    now()->format('d/m/Y H:i:00')
                );
                $hours_data = $moba->getHours(
                    $vehicle->plate,
                    now()->subDays(10)->format('d/m/Y H:i:00'),
                    now()->format('d/m/Y H:i:00')
                );

                $kms = $kms_data['valor'] ?? 0;
                $hours = $hours_data['valor'] ?? 0;
                $fechaHora = $kms_data['fechaHora'] ?? null;

                $data_xml = $moba->getData(
                    $vehicle->plate,
                    now()->subHours(1)->format('d/m/Y H:i:00'),
                    now()->format('d/m/Y H:i:00')
                );

                $xml = htmlspecialchars_decode($data_xml);
                $dom = new \DOMDocument();
                $dom->loadXML($xml);

                $pos_nodes = $dom->getElementsByTagName('POSICION');
                $pos_count = $pos_nodes->length;

                if ($pos_count > 0) {
                    $pos = $pos_nodes->item($pos_count - 1);

                    $lat_nodes = $pos->getElementsByTagName('POS_LATITUD');
                    $lng_nodes = $pos->getElementsByTagName('POS_LONGITUD');

                    if ($lat_nodes->length > 0 && $lng_nodes->length > 0) {
                        $lat = $lat_nodes->item(0)->nodeValue;
                        $lng = $lng_nodes->item(0)->nodeValue;
                        $address = $maps->reverseGeocode($lat, $lng);
                    }
                }
            } catch (\Throwable $e) {
                // En modo debug simplemente ignoramos el error de este vehículo concreto
                continue;
            }

            $rows[] = [
                'service' => $service_key,
                'plate' => $plate_normalized,
                'kms' => $kms ? (float) $kms : null,
                'engine_hours' => $hours ? (float) $hours : null,
                'meta' => [
                    'fechaHora' => $fechaHora,
                    'lat' => $lat,
                    'lng' => $lng,
                    'address' => $address,
                ],
                'raw' => null,
            ];
        }

        return $rows;
    }

    public function getAvailableServiceKeys() : array
    {
        $config = config('services.moba') ?? [];

        // Exponemos las claves que empiezan por "acciona_"
        $keys = [];
        foreach (array_keys($config) as $key) {
            if (str_starts_with($key, 'acciona_')) {
                $keys[] = $key;
            }
        }

        return $keys;
    }
}

