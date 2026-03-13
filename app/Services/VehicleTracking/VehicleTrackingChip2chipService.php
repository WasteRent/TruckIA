<?php

namespace App\Services\VehicleTracking;

use App\Classes\Chip2Chip\Chip2chipClient;

class VehicleTrackingChip2chipService implements VehicleTrackingServiceInterface
{
    public function getDataByPlate(string $plate) : array
    {
        $normalized_plate = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $plate));

        $service_keys = $this->getChip2chipServiceKeys();

        $rows = [];

        foreach ($service_keys as $service_key) {
            $service_rows = $this->getDataForService($service_key, ['plate' => $normalized_plate]);
            $rows = array_merge($rows, $service_rows);
        }

        return $rows;
    }

    public function getDataForService(string $service_key, array $filters = []) : array
    {
        $asset_group_id = config("services.chip2chip.{$service_key}.asset_group_id");
        $token_username = config("services.chip2chip.{$service_key}.token_username");

        if (! $asset_group_id || ! $token_username) {
            return [];
        }

        $client = new Chip2chipClient(
            config('services.chip2chip.acciona.api_base_url'),
            config('services.chip2chip.acciona.token_base_url'),
            config('services.chip2chip.acciona.client_id'),
            config('services.chip2chip.acciona.client_secret'),
            config('services.chip2chip.acciona.client_name'),
            $token_username,
            config('services.chip2chip.acciona.token_password')
        );

        $assets = $client->getAssets((int) $asset_group_id) ?? [];

        $asset_ids = [];
        $asset_meta = [];

        foreach ($assets as $asset) {
            $registration = isset($asset['RegistrationNumber']) ? $asset['RegistrationNumber'] : '';
            $normalized_registration = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $registration));

            if (isset($filters['plate']) && $filters['plate']) {
                if ($normalized_registration !== $filters['plate']) {
                    continue;
                }
            }

            if (! isset($asset['AssetId'])) {
                continue;
            }

            $asset_id = $asset['AssetId'];

            $asset_ids[] = $asset_id;
            $asset_meta[$asset_id] = [
                'plate' => $normalized_registration,
                'raw_asset' => $asset,
            ];
        }

        if (! count($asset_ids)) {
            return [];
        }

        $trips = $client->getLatestTrips($asset_ids) ?? [];

        $rows = [];

        foreach ($asset_ids as $asset_id) {
            $plate = $asset_meta[$asset_id]['plate'] ?? null;
            $kms = null;
            $engine_hours = null;
            $raw_trip = null;

            foreach ($trips as $trip) {
                if (! isset($trip['AssetId']) || $trip['AssetId'] !== $asset_id) {
                    continue;
                }

                $raw_trip = $trip;

                if (isset($trip['EndOdometerKilometers'])) {
                    $kms = $trip['EndOdometerKilometers'];
                }

                if (isset($trip['EndEngineSeconds']) && $trip['EndEngineSeconds'] !== null) {
                    $engine_hours = $trip['EndEngineSeconds'] / 3600;
                }

                break;
            }

            $rows[] = [
                'service' => $service_key,
                'plate' => $plate,
                'kms' => $kms,
                'engine_hours' => $engine_hours,
                'meta' => [
                    'asset_id' => $asset_id,
                ],
                'raw' => [
                    'asset' => $asset_meta[$asset_id]['raw_asset'] ?? null,
                    'trip' => $raw_trip,
                ],
            ];
        }

        $rows = $this->applyFilters($rows, $filters);

        return $rows;
    }

    public function getAvailableServiceKeys() : array
    {
        $config = config('services.chip2chip') ?? [];

        $keys = [];

        foreach (array_keys($config) as $key) {
            if (str_starts_with($key, 'acciona_chip2chip_')) {
                $keys[] = $key;
            }
        }

        return $keys;
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

