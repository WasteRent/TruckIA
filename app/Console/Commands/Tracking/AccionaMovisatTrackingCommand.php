<?php

namespace App\Console\Commands\Tracking;

use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\Movisat\MovisatClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Console\Command;

class AccionaMovisatTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:acciona-movisat';

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
            435 => 'acciona_coslada',
            415 => 'acciona_colmenar_viejo',
            599 => 'acciona_vinaros'
        ];

        foreach ($services as $location_id => $service) {
            $this->info("Procesando servicio: {$service} para location_id: {$location_id}");
            
            $client = new MovisatClient(
                config('services.movisat.'.$service.'.base_url'),
                config('services.movisat.'.$service.'.username'),
                config('services.movisat.'.$service.'.password'),
                config('services.movisat.'.$service.'.client_id'),
                config('services.movisat.'.$service.'.client_secret'),
                config('services.movisat.'.$service.'.company_id'),
            );

            try {
                foreach ($client->getDevices() as $device) {
                    $plate = preg_replace('/[^A-Za-z0-9]/', '', $device['plate']);
                    $vehicle = Vehicle::active()->where('plate', $plate)->where('fleet_id', 30)->where('location_id', $location_id)->first();
                    if (!$vehicle) {
                        $this->error("{$plate} not found for service {$service}.");
                        continue;
                    }

                    $this->info("{$plate} reading....");

                    try {
                        $data = $this->getData($client, $plate, $device);
                        if (!empty($data)) {
                            $this->updateData($vehicle, $data);
                            $this->info($vehicle->plate . ' - ' . $data['kms'] . ' - ' . $data['hours']);
                        }
                    } catch (\Exception|\Throwable $e) {
                        $this->error("{$plate} - {$e->getMessage()}");
                    }
                }
            } catch (\Exception|\Throwable $e) {
                $this->error("Error procesando servicio {$service}: {$e->getMessage()}");
            }
        }
    }

    private function getData(MovisatClient $client, string $plate, array $device){
        $hash = md5(microtime());

        try {
            $position = $client->getPosition($device['movil']);
            $kms = $client->getKms($device['movil']);
            $hours = $client->getHours($device['movil']);

            $message_uid = md5($hash . $plate);

            if (VehicleTracking::where('message_uid', $message_uid)->exists()) {
                $this->error("{$plate} message already exists.");
                return;
            }

            if (!$position && !$hours && !$kms) {
                $this->error("{$plate} no data found.");
                return;
            }          
            return [
                'message_uid' => $message_uid,
                'kms' => $kms,
                'hours' => $hours,
                'position' => $position,
            ];
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
            return;
        }
    }

    private function updateData(Vehicle $vehicle, array $data)
    {
        $maps = app(GeocodeClient::class);

        $address = '';
        if (!empty($data["position"]) && isset($data["position"]["Lat"]) && isset($data["position"]["Lng"])) {
            $address = $maps->reverseGeocode($data["position"]["Lat"], $data["position"]["Lng"]) ?? '';
        }

        VehicleTracking::create([
            'vehicle_id' => $vehicle->id,
            'message_uid' => $data['message_uid'],
            'kms' => $data['kms'] ?? 0,
            'engine_minutes' => $data['hours'] ? $data['hours']*60 : 0,
            'fuel_level_percent' => 0,
            'address' => $address,
            'latitude' => $data["position"]["Lat"] ?? '',
            'longitude' => $data["position"]["Lng"] ?? '',
            'fired_at' => $data["position"]["Fecha"] ?? now(),
            'service' => 'acciona_movisat'
        ]);

        $vehicle->incrementKms($data['kms'] - $vehicle->kms);
        if ($data['hours']) {
            $vehicle->incrementCanHours(abs($data['hours'] - $vehicle->chassis_can_work_hours));
        }

    }

}
