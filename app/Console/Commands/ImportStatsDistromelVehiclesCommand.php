<?php

namespace App\Console\Commands;

use App\Classes\Distromel\DistromelClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Console\Command;

class ImportStatsDistromelVehiclesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distromel:import-vehicle-stats';

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
        $client = app(DistromelClient::class);

        foreach (Vehicle::where('fleet_id', 30)->whereNotNull('webfleet_id')->get() as $vehicle) {
            $data = $client->getResourceStats($vehicle->webfleet_id);
            $message_uid = md5("{$vehicle->plate}:{$data['TotalDistanceKm']}:{$data['TotalEngineHours']}");

            if (VehicleTracking::where('message_uid', $message_uid)->exists()) {
                $this->info('Skipping: ' . "{$vehicle->plate}:{$data['TotalDistanceKm']}:{$data['TotalEngineHours']}");
                continue;
            }

            VehicleTracking::create([
                'vehicle_id' => $vehicle->id,
                'message_uid' => $message_uid,
                'kms' => $data['TotalDistanceKm'],
                'engine_minutes' => $data['TotalEngineHours'] * 60.0,
                'fuel_level_percent' => null,
                'address' => '',
                'latitude' => '',
                'longitude' => '',
                'fired_at' => now(),
            ]);

            $vehicle->incrementKms($data['TotalDistanceKm'] - $vehicle->kms);
            /*$vehicle->incrementCanHours($data['TotalEngineHours'] - $vehicle->chassis_can_work_hours);*/

            $this->info($vehicle->plate);
        }

        return Command::SUCCESS;
    }
}
