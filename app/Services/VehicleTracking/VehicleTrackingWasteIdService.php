<?php

namespace App\Services\VehicleTracking;

use App\Classes\WasteId\WasteIdClient;
use App\Models\Fleet;
use App\Models\Vehicle;

class VehicleTrackingWasteIdService implements VehicleTrackingServiceInterface
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
        // Por ahora solo tenemos una configuración global de WasteId,
        // por lo que ignoramos $service_key y usamos siempre la misma API.
        $config = config('services.wasteid');

        if (! $config) {
            return [];
        }

        $client = new WasteIdClient(
            $config['api_base_url'],
            $config['login_url'],
            $config['api_key'],
            $config['api_secret']
        );

        // Reutilizamos parte de la lógica del comando AccionaWasteIdTrackingCommand:
        $bbdd_vehicles = Vehicle::where('fleet_id', Fleet::ACCIONA)->get();
        $api_devices = $client->getDevices();

        $vehicle_device_map = [];

        foreach ($bbdd_vehicles as $vehicle) {
            $plate_normalized = str_replace(['-', ' '], '', $vehicle->plate);

            foreach ($api_devices as $device) {
                $device_plate = $device['DeviceLicensePlate'] ?? '';
                $device_plate_normalized = str_replace(['-', ' '], '', $device_plate);

                if ($plate_normalized !== $device_plate_normalized) {
                    continue;
                }

                $vehicle_device_map[$vehicle->id] = (int) $device['DeviceId'];
                break;
            }
        }

        if (empty($vehicle_device_map)) {
            return [];
        }

        $yesterday_start = now()->subDay()->startOfDay()->toIso8601String();
        $yesterday_end = now()->subDay()->endOfDay()->toIso8601String();

        $vehicles = $bbdd_vehicles->keyBy('id');

        $rows = [];

        foreach ($vehicle_device_map as $vehicle_id => $device_id) {
            $vehicle = $vehicles->get($vehicle_id);
            if (! $vehicle) {
                continue;
            }

            try {
                $coords = $client->getDeviceRoute($device_id, $yesterday_start, $yesterday_end);
            } catch (\Throwable $e) {
                continue;
            }

            if (empty($coords)) {
                continue;
            }

            $last = end($coords);
            $mileage = isset($last['Mileage']) ? (int) $last['Mileage'] : 0;
            $motor_hours = isset($last['MotorHours']) ? (int) $last['MotorHours'] : 0;

            $rows[] = [
                'service' => $service_key,
                'plate' => strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $vehicle->plate)),
                'kms' => $mileage > 0 ? (float) $mileage : null,
                'engine_hours' => $motor_hours > 0 ? (float) $motor_hours : null,
                'meta' => [
                    'device_id' => $device_id,
                ],
                'raw' => [
                    'last_coord' => $last,
                ],
            ];
        }

        // Filtro por matrícula si se ha pasado
        if (isset($filters['plate']) && $filters['plate']) {
            $rows = array_values(array_filter($rows, function (array $row) use ($filters) {
                return $row['plate'] === $filters['plate'];
            }));
        }

        return $rows;
    }

    public function getAvailableServiceKeys() : array
    {
        // De momento un único servicio lógico para WasteId
        return ['acciona_wasteid'];
    }
}

