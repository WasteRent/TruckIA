<?php

namespace App\Services\VehicleTracking;

use App\Classes\WeMob\WeMobClient;
use App\Models\Vehicle;

class VehicleTrackingWemobService implements VehicleTrackingServiceInterface
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
        if ($service_key === 'acciona_wemob') {
            return $this->getAccionaData($filters);
        }

        if ($service_key === 'svat_wemob') {
            return $this->getSvatData($filters);
        }

        return [];
    }

    public function getAvailableServiceKeys() : array
    {
        return [
            'acciona_wemob',
            'svat_wemob',
        ];
    }

    private function getAccionaData(array $filters = []) : array
    {
        $base_url = config('services.wemob.acciona_general.base_url');
        $username = config('services.wemob.acciona_general.username');
        $password = config('services.wemob.acciona_general.password');

        if (! $base_url || ! $username || ! $password) {
            return [];
        }

        $wemob = new WeMobClient(
            $base_url,
            $username,
            $password
        );

        $eco_data = collect($wemob->getEcoData())
            ->sortByDesc('timestamp')
            ->groupBy('plate')
            ->map(function ($reads) {
                return $reads[0];
            })
            ->values();

        $rows = [];

        foreach ($wemob->getGridData() as $data) {
            $eco = $eco_data->where('plate', $data->plate)->first();

            if ($eco) {
                $data->chassis_hours = $eco->chassis_hours;
                $data->power_takeoff_hours = $eco->power_takeoff_hours;
            }

            $vehicle = Vehicle::active()
                ->where('plate', $data->plate)
                ->where('fleet_id', 30)
                ->first();

            if (! $vehicle) {
                continue;
            }

            $normalized_plate = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $data->plate));

            if (isset($filters['plate']) && $filters['plate']) {
                if ($normalized_plate !== $filters['plate']) {
                    continue;
                }
            }

            $kms_value = $data->kms !== null ? (float) $data->kms : null;
            $hours_value = $data->chassis_hours !== null ? (float) $data->chassis_hours : null;

            $rows[] = [
                'service' => 'acciona_wemob',
                'plate' => $normalized_plate,
                'kms' => $kms_value,
                'engine_hours' => $hours_value,
                'meta' => [
                    'fleet_alias' => $data->fleet_alias,
                    'fuel_level' => $data->fuel_level,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'power_takeoff_hours' => $data->power_takeoff_hours,
                    'state' => $data->state,
                    'timestamp' => $data->timestamp,
                ],
                'raw' => $data,
            ];
        }

        return $rows;
    }

    private function getSvatData(array $filters = []) : array
    {
        $base_url = config('services.wemob.svat.base_url');
        $username = config('services.wemob.svat.username');
        $password = config('services.wemob.svat.password');

        if (! $base_url || ! $username || ! $password) {
            return [];
        }

        $wemob = new WeMobClient(
            $base_url,
            $username,
            $password
        );

        $rows = [];

        foreach ($wemob->getMobileData() as $data) {
            $vehicle = Vehicle::active()
                ->where('plate', $data->plate)
                ->where('fleet_id', 31)
                ->first();

            if (! $vehicle) {
                continue;
            }

            $normalized_plate = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $data->plate));

            if (isset($filters['plate']) && $filters['plate']) {
                if ($normalized_plate !== $filters['plate']) {
                    continue;
                }
            }

            $kms_value = $data->kms !== null ? (float) $data->kms : null;
            $hours_value = $data->chassis_hours !== null ? (float) $data->chassis_hours : null;

            $rows[] = [
                'service' => 'svat_wemob',
                'plate' => $normalized_plate,
                'kms' => $kms_value,
                'engine_hours' => $hours_value,
                'meta' => [
                    'fuel_level' => $data->fuel_level,
                    'fuel_consumption' => $data->fuel_consumption,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'power_takeoff_hours' => $data->power_takeoff_hours,
                    'timestamp' => $data->timestamp,
                ],
                'raw' => $data,
            ];
        }

        return $rows;
    }
}

