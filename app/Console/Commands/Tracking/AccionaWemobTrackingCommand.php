<?php

namespace App\Console\Commands\Tracking;

use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\WeMob\WeMobClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Illuminate\Console\Command;

class AccionaWemobTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:acciona-wemob';

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
        $services = ['acciona_general', 'acciona_eltoyo', 'acciona_almeria', 'acciona_cenes_de_la_vega', 'acciona_el_cuervo'];

        foreach ($services as $service) {
            $wemob = new WeMobClient(
                config("services.wemob.{$service}.base_url"),
                config("services.wemob.{$service}.username"),
                config("services.wemob.{$service}.password")
            );

            foreach ($wemob->getData() as $data) {
                $this->updateData($data);
            }
        }
    }

    private function updateData($data)
    {
        $maps = app(GeocodeClient::class);

        $vehicle = Vehicle::active()->where('plate', $data->plate)->where('fleet_id', 30)->first();

        if (! $vehicle) {
            return;
        }

        $message_uid = md5($data->plate.$data->timestamp);

        if (VehicleTracking::where('message_uid', $message_uid)->exists()) {
            return;
        }

        VehicleTracking::create([
            'vehicle_id' => $vehicle->id,
            'message_uid' => $message_uid,
            'kms' => $data->kms,
            'engine_minutes' => $data->chassis_hours * 60.0,
            'fuel_level_percent' => $data->fuel_level,
            'address' => $maps->reverseGeocode($data->latitude, $data->longitude),
            'latitude' => $data->latitude,
            'longitude' => $data->longitude,
            'fired_at' => date('Y-m-d H:i:s', $data->timestamp / 1000),
        ]);

        $vehicle->incrementKms($data->kms - $vehicle->kms);

        if ($data->chassis_hours) {
            $vehicle->incrementCanHours($data->chassis_hours - $vehicle->chassis_can_work_hours);
        }

        if ($data->power_takeoff_hours) {
            $vehicle->incrementEquipmentHours($data->power_takeoff_hours - $vehicle->equipment_work_hours);
        }

        $this->info($vehicle->plate . ' - ' . $data->chassis_hours . ' - ' . $data->power_takeoff_hours);
    }
}
