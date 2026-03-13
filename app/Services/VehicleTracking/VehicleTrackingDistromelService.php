<?php

namespace App\Services\VehicleTracking;

use App\Classes\Distromel\DistromelClient;

class VehicleTrackingDistromelService implements VehicleTrackingServiceInterface
{
    public function getDataByPlate(string $plate) : array
    {
        $normalized_plate = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $plate));

        $rows = [];

        foreach ($this->getDistromelServiceKeys() as $service_key) {
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

        $resources = $client->getResources();

        $rows = [];

        foreach ($resources as $resource) {
            if (! isset($resource->Id) || ! isset($resource->Description)) {
                continue;
            }

            $description = (string) $resource->Description;
            $plate = $this->extractPlateFromDescription($description);
            $normalized_plate = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $plate));

            if (isset($filters['plate']) && $filters['plate']) {
                if ($normalized_plate !== $filters['plate']) {
                    continue;
                }
            }

            $stats = $client->getResourceStats((string) $resource->Id);

            $kms = isset($stats['TotalDistanceKm']) ? (float) $stats['TotalDistanceKm'] : null;
            $hours = isset($stats['TotalEngineHours']) ? (float) $stats['TotalEngineHours'] : null;

            $rows[] = [
                'service' => $service_key,
                'plate' => $normalized_plate ?: null,
                'kms' => $kms,
                'engine_hours' => $hours,
                'meta' => [
                    'resource_id' => (string) $resource->Id,
                ],
                'raw' => [
                    'resource' => $resource,
                    'stats' => $stats,
                ],
            ];
        }

        $rows = $this->applyFilters($rows, $filters);

        return $rows;
    }

    public function getAvailableServiceKeys() : array
    {
        return $this->getDistromelServiceKeys();
    }

    private function buildClient(string $service_key) : ?DistromelClient
    {
        $base_url = config('services.distromel.acciona.base_url');
        $username = config('services.distromel.acciona.username');
        $password = config('services.distromel.acciona.password');
        $key = config("services.distromel.{$service_key}.key");

        if (! $base_url || ! $username || ! $password || ! $key) {
            return null;
        }

        return new DistromelClient(
            $base_url,
            $username,
            $password,
            $key
        );
    }

    private function getDistromelServiceKeys() : array
    {
        $config = config('services.distromel') ?? [];

        $keys = [];

        foreach (array_keys($config) as $key) {
            if ($key === 'acciona' || $key === 'base') {
                continue;
            }

            $keys[] = $key;
        }

        return $keys;
    }

    private function extractPlateFromDescription(string $description) : string
    {
        if (preg_match('/([0-9]{4}[ -]?[A-Z]{3})/', $description, $matches)) {
            return $matches[1];
        }

        if (preg_match('/([A-Z]-[0-9]{4}-[A-Z]{3})/', $description, $matches)) {
            return $matches[1];
        }

        return '';
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

