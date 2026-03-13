<?php

namespace App\Services\VehicleTracking;

use App\Classes\Movisat\MovisatClient;

class VehicleTrackingMovisatService implements VehicleTrackingServiceInterface
{
    public function getDataByPlate(string $plate) : array
    {
        $normalized_plate = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $plate));

        $rows = [];

        foreach ($this->getMovisatServiceKeys() as $service_key) {
            $service_rows = $this->getDataForService($service_key, ['plate' => $normalized_plate]);
            $rows = array_merge($rows, $service_rows);
        }

        return $rows;
    }

    public function getDataForService(string $service_key, array $filters = []) : array
    {
        $client = $this->buildClient($service_key);

        if (! $client) {
            return [];
        }

        $devices = $client->getDevices();

        $rows = [];

        foreach ($devices as $device) {
            $plate = preg_replace('/[^A-Za-z0-9]/', '', $device['plate']);
            $normalized_plate = strtoupper($plate);

            if (isset($filters['plate']) && $filters['plate']) {
                if ($normalized_plate !== $filters['plate']) {
                    continue;
                }
            }

            $kms = $client->getKms($device['movil']);
            $hours = $client->getHours($device['movil']);

            $kms_value = $kms !== null ? (float) $kms : null;
            $hours_value = $hours !== null ? (float) $hours : null;

            $rows[] = [
                'service' => $service_key,
                'plate' => $normalized_plate,
                'kms' => $kms_value,
                'engine_hours' => $hours_value,
                'meta' => [
                    'movil_id' => $device['movil'],
                ],
                'raw' => [
                    'kms' => $kms,
                    'hours' => $hours,
                ],
            ];
        }

        $rows = $this->applyFilters($rows, $filters);

        return $rows;
    }

    public function getAvailableServiceKeys() : array
    {
        return $this->getMovisatServiceKeys();
    }

    private function buildClient(string $service_key) : ?MovisatClient
    {
        $base_url = config("services.movisat.{$service_key}.base_url");
        $username = config("services.movisat.{$service_key}.username");
        $password = config("services.movisat.{$service_key}.password");
        $client_id = config("services.movisat.{$service_key}.client_id");
        $client_secret = config("services.movisat.{$service_key}.client_secret");
        $company_id = config("services.movisat.{$service_key}.company_id");

        if (! $base_url || ! $username || ! $password || ! $client_id || ! $client_secret || ! $company_id) {
            return null;
        }

        return new MovisatClient(
            $base_url,
            $username,
            $password,
            $client_id,
            $client_secret,
            $company_id
        );
    }

    private function getMovisatServiceKeys() : array
    {
        $config = config('services.movisat') ?? [];

        return array_keys($config);
    }

    private function applyFilters(array $rows, array $filters) : array
    {
        return array_values(array_filter($rows, function (array $row) use ($filters) {
            if (isset($filters['plate']) && $filters['plate']) {
                if ($row['plate'] !== $filters['plate']) {
                    return false;
                }
            }

            if (isset($filters['kms_from']) && $filters['kms_from'] !== null) {
                if ($row['kms'] === null || $row['kms'] < $filters['kms_from']) {
                    return false;
                }
            }

            if (isset($filters['kms_to']) && $filters['kms_to'] !== null) {
                if ($row['kms'] === null || $row['kms'] > $filters['kms_to']) {
                    return false;
                }
            }

            if (isset($filters['hours_from']) && $filters['hours_from'] !== null) {
                if ($row['engine_hours'] === null || $row['engine_hours'] < $filters['hours_from']) {
                    return false;
                }
            }

            if (isset($filters['hours_to']) && $filters['hours_to'] !== null) {
                if ($row['engine_hours'] === null || $row['engine_hours'] > $filters['hours_to']) {
                    return false;
                }
            }

            return true;
        }));
    }
}

