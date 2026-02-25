<?php

namespace App\Console\Commands\Tracking;

use App\Classes\WasteId\WasteIdClient;
use App\Models\Fleet;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Console\Command;

class AccionaWasteIdTrackingCommand extends Command
{
    protected $signature = 'tracking:acciona-wasteid';

    protected $description = 'Obtener las horas de motor y los km de los vehículos de Acciona desde WasteId';

    protected WasteIdClient $client;

    public function handle()
    {
        $wasteid_config = config('services.wasteid');

        $this->client = new WasteIdClient(
            $wasteid_config['api_base_url'],
            $wasteid_config['login_url'],
            $wasteid_config['api_key'],
            $wasteid_config['api_secret']
        );

        $vehicle_device_map = $this->fetchData();

        if (empty($vehicle_device_map)) {
            $this->warn('No se encontraron vehículos Acciona mapeados con dispositivos WasteId.');
            return 0;
        }

        $yesterday_start = now()->subDay()->startOfDay()->toIso8601String();
        $yesterday_end = now()->subDay()->endOfDay()->toIso8601String();

        $this->updateVehicles($vehicle_device_map, $yesterday_start, $yesterday_end);

        return 0;
    }

    private function fetchData(): array
    {
        $bbdd_vehicles = Vehicle::where('fleet_id', Fleet::ACCIONA)->get();
        $api_devices = $this->client->getDevices();

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

        return $vehicle_device_map;
    }

    private function updateVehicles(array $vehicle_device_map, string $yesterday_start, string $yesterday_end): void
    {
        $vehicles = Vehicle::whereIn('id', array_keys($vehicle_device_map))->get();

        foreach ($vehicle_device_map as $vehicle_id => $device_id) {
            $vehicle = $vehicles->firstWhere('id', $vehicle_id);

            if (! $vehicle) {
                continue;
            }

            try {
                $coords = $this->client->getDeviceRoute($device_id, $yesterday_start, $yesterday_end);
            } catch (\Throwable $e) {
                $this->warn("Error obteniendo ruta para {$vehicle->plate} (DeviceId {$device_id}): {$e->getMessage()}");
                continue;
            }

            if (empty($coords)) {
                $this->info("Sin coordenadas ayer para {$vehicle->plate} (DeviceId {$device_id})");
                continue;
            }

            $last = end($coords);
            $mileage = isset($last['Mileage']) ? (int) $last['Mileage'] : 0;
            $motor_hours = isset($last['MotorHours']) ? (int) $last['MotorHours'] : 0;
            $latitude = $last['Latitude'] ?? 0;
            $longitude = $last['Longitude'] ?? 0;
            $date_time = $last['DateTime'] ?? now()->subDay()->endOfDay()->toIso8601String();

            $engine_minutes = $motor_hours !== 0 ? $motor_hours * 60 : 0;
            $message_uid = md5("{$vehicle->plate}:{$mileage}:{$engine_minutes}:{$date_time}:wasteid");

            $tracking_data = [
                'vehicle_id' => $vehicle->id,
                'message_uid' => $message_uid,
                'kms' => $mileage,
                'fuel_level_percent' => null,
                'address' => '',
                'latitude' => $latitude,
                'longitude' => $longitude,
                'fired_at' => now(),
                'created_at' => now(),
                'service' => 'acciona_wasteid',
                'engine_minutes' => $engine_minutes,
            ];

            VehicleTracking::updateOrCreate(['message_uid' => $message_uid], $tracking_data);

            try {
                if ($mileage !== null) {
                    $vehicle->incrementKms($mileage - $vehicle->kms);
                }
                if ($engine_minutes !== null && $motor_hours !== null) {
                    $vehicle->incrementChassisHours($motor_hours - $vehicle->chassis_can_work_hours);
                }
            } catch (\Exception $e) {
                $this->error("Error actualizando estadísticas del vehículo {$vehicle->plate}: {$e->getMessage()}");
            }

            $this->info("{$vehicle->plate}: km={$mileage}, motor_hours={$motor_hours}");
        }
    }
}
