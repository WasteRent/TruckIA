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
     * Cliente Chip2chip
     * 
     * @var Chip2chipClient
     */
    protected $client;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->client = new Chip2chipClient(config('services.chip2chip.acciona.api_base_url'),
                                      config('services.chip2chip.acciona.token_base_url'),
                                      config('services.chip2chip.acciona.client_id'),
                                      config('services.chip2chip.acciona.client_secret'),
                                      config('services.chip2chip.acciona.client_name'),
                                      config('services.chip2chip.acciona.token_username'),
                                      config('services.chip2chip.acciona.token_password'));

        $assets_ids = $this->fetchData();
        $this->updateVehicles($assets_ids);
    }

    private function fetchData() : array {
       $bbdd_vehicles = Vehicle::where('fleet_id', 30)->get();
       $response_vehicles = $this->client->getAssets() ?? throw new \Exception('No vehicles found');
       $assets_ids = [];

       foreach ($bbdd_vehicles as $vehicle) {
           foreach ($response_vehicles as $chip2chip_vehicle) {
               $formatted_registration = str_replace('-', '', $chip2chip_vehicle['RegistrationNumber']);
               if ($vehicle->plate == $formatted_registration) {
                    $assets_ids[$vehicle->id] = $chip2chip_vehicle['AssetId'];
               }
           }
       }

       return $assets_ids;
    }

    private function updateVehicles(array $assets_ids) {    
        $vehicles = Vehicle::whereIn('id', array_keys($assets_ids))->get();
        $trips = $this->client->getLatestTrips(array_values($assets_ids)) ?? throw new \Exception('No trips found');
        $data = $this->prepareVehicleTripsData($assets_ids, $trips);
        
        foreach ($data as $item) {
            $vehicle = $vehicles->firstWhere('id', $item['vehicle_id']);
            
            if (!$vehicle) continue;
            
            foreach ($item['trips'] as $trip) {
                $duration_in_hours = $trip['Duration'] / 60;
                $message_uid = md5("{$vehicle->plate}:{$trip['EndOdometerKilometers']}:{$duration_in_hours}:{$trip['TripStart']}:{$trip['TripEnd']}");
                    
                if (VehicleTracking::where('message_uid', $message_uid)->where('kms', '>', 0)->exists()) {
                    $this->info('Skipping: '."{$vehicle->plate}:{$trip['EndOdometerKilometers']}:{$duration_in_hours}:{$trip['TripStart']}:{$trip['TripEnd']}");
                    continue;
                }
                
                VehicleTracking::updateOrCreate([
                                'message_uid' => $message_uid,
                            ], [
                                'vehicle_id' => $vehicle->id,
                                'message_uid' => $message_uid,
                                'kms' => $trip['EndOdometerKilometers'],
                                'engine_minutes' => $trip['EndEngineSeconds'] / 60.0,
                                'fuel_level_percent' => null,
                                'address' => '',
                                'latitude' => $trip['EndPosition']['Latitude'],
                                'longitude' => $trip['EndPosition']['Longitude'],
                                'fired_at' => now(),
                                'created_at' => now(),
                ]);

                try {
                    $vehicle->incrementKms($trip['EndOdometerKilometers'] - $vehicle->kms);
                    $vehicle->incrementChassisHours(($trip['EndEngineSeconds'] / 3600) - $vehicle->chassis_can_work_hours);
                } catch (\Exception $e) {
                    $this->error("Error incrementing vehicle stats: {$e->getMessage()}");
                }
                
                $this->info("{$vehicle->plate}:{$trip['EndOdometerKilometers']}:{$duration_in_hours}:{$trip['TripStart']}:{$trip['TripEnd']}");
                
            }
        }
    }

    private function prepareVehicleTripsData(array $assets_ids, array $trips): array {
        $data = [];
        
        foreach ($assets_ids as $vehicle_id => $asset_id) {
            $data[] = [
                "vehicle_id" => $vehicle_id,
                "asset_id" => $asset_id,
                "trips" => []
            ];
        }
        
        foreach ($trips as $trip) {
            $asset_id = $trip['AssetId'];
            foreach ($data as &$item) {
                if ($item['asset_id'] == $asset_id) {
                    $item['trips'][] = $trip;
                    break;
                }
            }
        }
        
        return $data;
    }
}
