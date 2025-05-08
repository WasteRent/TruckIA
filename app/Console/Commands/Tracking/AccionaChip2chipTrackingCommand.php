<?php

namespace App\Console\Commands\Tracking;

use App\Classes\Chip2Chip\Chip2chipClient;
use App\Classes\Distromel\DistromelClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Console\Command;

class AccionaChip2chipTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:acciona-chip2chip';

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

        $client = new Chip2chipClient(config('services.chip2chip.acciona.api_base_url'),
                                      config('services.chip2chip.acciona.id_base_url'),
                                      config('services.chip2chip.acciona.client_id'),
                                      config('services.chip2chip.acciona.client_secret'),
                                      config('services.chip2chip.acciona.client_name'),
                                      config('services.chip2chip.acciona.token_username'),
                                      config('services.chip2chip.acciona.token_password'));

        $fetched_ids = $this->fetchData($client);
        $this->updateVehicles($client, $fetched_ids);
    }

    private function fetchData(Chip2chipClient $client) : array {
       $bbdd_vehicles = Vehicle::where('fleet_id', 30)->get();
       $response_vehicles = $client->getAssets() ?? throw new \Exception('No vehicles found');
       $fetched_ids = [];

       foreach ($bbdd_vehicles as $vehicle) {
           foreach ($response_vehicles as $chip2chip_vehicle) {
               $formatted_registration = str_replace('-', '', $chip2chip_vehicle['RegistrationNumber']);
               if ($vehicle->plate == $formatted_registration) {
                    $fetched_ids[] = $chip2chip_vehicle['AssetId'];
                    if($vehicle->webfleet_id == null || $vehicle->webfleet_id == '' || $vehicle->webfleet_id != $chip2chip_vehicle['AssetId']) {
                        $vehicle->update(['webfleet_id' => $chip2chip_vehicle['AssetId']]);
                    }
               }
           }
       }

       return $fetched_ids;
    }

    private function updateVehicles(Chip2chipClient $client, array $fetched_ids) {    
        $vehicles = Vehicle::where('fleet_id', 30)->where('webfleet_id', '!=', null)->get();
        $latest_trips = $client->getLatestTrips($fetched_ids);


        foreach ($latest_trips as $trip) {
            foreach ($vehicles as $vehicle) {
                if($vehicle->webfleet_id == $trip['AssetId']) {
                    $duration_in_hours = floatval($trip['Duration']) / 60;
                    $message_uid = md5("{$vehicle->plate}:{$trip['DistanceKilometers']}:{$duration_in_hours}:{$trip['TripStart']}:{$trip['TripEnd']}");
                        
                    if (VehicleTracking::where('message_uid', $message_uid)->where('kms', '>', 0)->exists()) {
                        $this->info('Skipping: '."{$vehicle->plate}:{$trip['DistanceKilometers']}:{$duration_in_hours}:{$trip['TripStart']}:{$trip['TripEnd']}");
                        continue;
                    }

                    VehicleTracking::updateOrCreate([
                                    'message_uid' => $message_uid,
                                ], [
                                    'vehicle_id' => $vehicle->id,
                                    'message_uid' => $message_uid,
                                    'kms' => $trip['DistanceKilometers'],
                                    'engine_minutes' => $trip['EngineSeconds'] * 60.0,
                                    'fuel_level_percent' => null,
                                    'address' => '',
                                    'latitude' => '',
                                    'longitude' => '',
                                    'fired_at' => now(),
                                    'created_at' => now(),
                    ]);

                    try {
                        $vehicle->incrementKms($trip['DistanceKilometers'] - $vehicle->kms);
                        $vehicle->incrementChassisHours(($trip['EngineSeconds'] / 3600) - $vehicle->chassis_can_work_hours);
                    } catch (\Exception $e) {
                        $this->error("Error incrementing vehicle stats: {$e->getMessage()}");
                    }
                    
                    $this->info("{$vehicle->plate}:{$trip['DistanceKilometers']}:{$duration_in_hours}:{$trip['TripStart']}:{$trip['TripEnd']}");
                    
                }
            }
        }
    }
}
