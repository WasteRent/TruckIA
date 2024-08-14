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
        $maps = app(GeocodeClient::class);
        $client = new MovisatClient(
            config('services.movisat.acciona.base_url'),
            config('services.movisat.acciona.username'),
            config('services.movisat.acciona.password'),
            config('services.movisat.acciona.client_id'),
            config('services.movisat.acciona.client_secret'),
            config('services.movisat.acciona.company_id'),
        );

        $hash = md5(microtime());

        foreach ($client->getDevices() as $device) {
            $plate = preg_replace('/[^A-Za-z0-9]/', '', $device['plate']);
            $vehicle = Vehicle::active()->where('plate', $plate)->where('fleet_id', 30)->where('location_id', 92)->first(); //alcobendas

            if (! $vehicle) {
                $this->error("{$plate} not found.");
                continue;
            }

            $this->info("{$plate} reading....");

            $position = $client->getPosition($device['movil']);
            $kms = $client->getKms($device['movil']);
            $hours = $client->getHours($device['movil']);

            $message_uid = md5($hash . $plate);
            if (VehicleTracking::where('message_uid', $message_uid)->exists()) {
                $this->error("{$plate} message already exists.");
                continue;
            }

            VehicleTracking::create([
                'vehicle_id' => $vehicle->id,
                'message_uid' => $message_uid,
                'kms' => $kms ?? 0,
                'engine_minutes' => $hours ? $hours*60 : 0,
                'fuel_level_percent' => 0,
                'address' => $position ? $maps->reverseGeocode($position['Lat'], $position['Lng']) : '',
                'latitude' => $position['Lat'] ?? '',
                'longitude' => $position['Lng'] ?? '',
                'fired_at' => $position['Fecha'] ?? now()
            ]);

            $vehicle->incrementKms($kms - $vehicle->kms);
            if ($hours) {
                $vehicle->incrementCanHours($hours - $vehicle->chassis_can_work_hours);
            }

            $this->info($plate);
        }
    }

}
