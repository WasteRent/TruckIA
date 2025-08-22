<?php

namespace App\Console\Commands\Tracking;

use App\Classes\Distromel\DistromelClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Console\Command;

class AccionaDistromelTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:acciona-distromel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $services = [
            348 => 'accion_torrevieja',
            351 => 'acciona_calpe',
            414 => 'acciona_la_eliana'
        ];

        foreach ($services as $location_id => $service) {
            $client = new DistromelClient(
                config('services.distromel.acciona.base_url'),
                config('services.distromel.acciona.username'),
                config('services.distromel.acciona.password'),
                config('services.distromel.' . $service . '.key'),
            );

            $this->info("Fetching data for $service");
            
            $this->fetchData($client, $location_id);
        }
    }

    private function fetchData(DistromelClient $client, $location_id) {
        foreach (Vehicle::where('fleet_id', 30)->where('location_id', $location_id)->whereNotNull('webfleet_id')->get() as $vehicle) {
            $data = $client->getResourceStats($vehicle->webfleet_id);
            $message_uid = md5("{$vehicle->plate}:{$data['TotalDistanceKm']}:{$data['TotalEngineHours']}:{$data['TotalPtoHours']}");

            /*if (VehicleTracking::where('message_uid', $message_uid)->where('kms', '>', 0)->exists()) {
                $this->info('Skipping: '."{$vehicle->plate}:{$data['TotalDistanceKm']}:{$data['TotalEngineHours']}:{$data['TotalPtoHours']}");
                continue;
            }*/

            VehicleTracking::updateOrCreate([
                'message_uid' => $message_uid,
            ], [
                'vehicle_id' => $vehicle->id,
                'message_uid' => $message_uid,
                'kms' => $data['TotalDistanceKm'],
                'engine_minutes' => $data['TotalEngineHours'] * 60.0,
                'fuel_level_percent' => null,
                'address' => '',
                'latitude' => '',
                'longitude' => '',
                'fired_at' => now(),
                'created_at' => now(),
                'service' => 'acciona_distromel'
            ]);


            try {
                $vehicle->incrementKms($data['TotalDistanceKm'] - $vehicle->kms);
                $vehicle->incrementChassisHours($data['TotalEngineHours'] - $vehicle->chassis_can_work_hours);

                if ($data['TotalPtoHours'] > 0) {
                    $vehicle->incrementEquipmentHours($data['TotalPtoHours'] - $vehicle->equipment_work_hours);
                }
            } catch (\Exception $e) {
                $this->error("Error incrementing vehicle stats: {$e->getMessage()}");
            }

            $this->info("{$vehicle->plate}:{$data['TotalDistanceKm']}:{$data['TotalEngineHours']}:{$data['TotalPtoHours']}");
        }
    }
}
