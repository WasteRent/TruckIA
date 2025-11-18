<?php

namespace App\Console\Commands\Tracking;

use App\Classes\Chip2Chip\Chip2chipClient;
use App\Models\Fleet;
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

    protected $asset_group_ids = [
        'acciona.chip2chip+alcobendas@truckts.com' => 1625688632072515584,
        'acciona.chip2chip+calpe@truckts.com' => 1715905709795524608,
        'acciona.chip2chip+amappffl5@truckts.com' => 1722763030095560704,
        'acciona.chip2chip+cosladalv@truckts.com' => 1661293612688289792,
        'acciona.chip2chip+amapphhl2@truckts.com' => 1722728852167688192,
        'acciona.chip2chip+labaneza@truckts.com' => 1704709600382861312,
    ];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->asset_group_ids as $token_username => $asset_group_id) {
            $this->info("Procesando cuenta: {$token_username} (Asset Group ID: {$asset_group_id})");
            
            $this->client = new Chip2chipClient(config('services.chip2chip.acciona.api_base_url'),
                                        config('services.chip2chip.acciona.token_base_url'),
                                        config('services.chip2chip.acciona.client_id'),
                                        config('services.chip2chip.acciona.client_secret'),
                                            config('services.chip2chip.acciona.client_name'),
                                            $token_username,
                                            config('services.chip2chip.acciona.token_password'));

            $assets_ids = $this->fetchData($asset_group_id);
            
            if (empty($assets_ids)) {
                $this->warn("No se encontraron vehículos para la cuenta: {$token_username}");
                continue;
            }
            
            $this->updateVehicles($assets_ids);
        }
    }

    private function fetchData(int $asset_group_id) : array {
       $bbdd_vehicles = Vehicle::where('fleet_id', Fleet::ACCIONA)->get();
       $response_vehicles = $this->client->getAssets($asset_group_id) ?? throw new \Exception('No vehicles found');
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

                $tracking_data = [
                    'vehicle_id' => $vehicle->id,
                    'message_uid' => $message_uid,
                    'kms' => round($trip['EndOdometerKilometers']),
                    'fuel_level_percent' => null,
                    'address' => '',
                    'latitude' => $trip['EndPosition']['Latitude'],
                    'longitude' => $trip['EndPosition']['Longitude'],
                    'fired_at' => now(),
                    'created_at' => now(),
                    'service' => 'acciona_chip2chip'
                ];

                if (isset($trip['EndEngineSeconds']) && $trip['EndEngineSeconds'] !== null) {
                    $tracking_data['engine_minutes'] = $trip['EndEngineSeconds'] / 60.0;
                } else {
                    $tracking_data['engine_minutes'] = null;
                }
                
                VehicleTracking::updateOrCreate([
                    'message_uid' => $message_uid,
                ], $tracking_data);

                try {
                    $vehicle->incrementKms($trip['EndOdometerKilometers'] - $vehicle->kms);
                    
                    if (isset($trip['EndEngineSeconds']) && $trip['EndEngineSeconds'] !== null) {
                        $vehicle->incrementChassisHours(($trip['EndEngineSeconds'] / 3600) - $vehicle->chassis_can_work_hours);
                    }
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
