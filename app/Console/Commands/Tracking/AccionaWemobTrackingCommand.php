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
        $wemob = new WeMobClient(
            config("services.wemob.acciona_general.base_url"),
            config("services.wemob.acciona_general.username"),
            config("services.wemob.acciona_general.password")
        );

        $ecoData = collect($wemob->getEcoData())
                        ->sortByDesc('timestamp')
                        ->groupBy('plate')
                        ->map(function($reads) {
                            return $reads[0];
                        })
                        ->values();

        foreach ($wemob->getGridData() as $data) {
            $data->chassis_hours = collect($ecoData)->where('plate', $data->plate)->first()?->chassis_hours;
            $data->power_takeoff_hours = collect($ecoData)->where('plate', $data->plate)->first()?->power_takeoff_hours;

            $this->info(json_encode($data));
            $this->updateData($data);
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

        if (VehicleTracking::where('message_uid', $message_uid)->exists() || $data->kms == 0) {
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
            'service' => 'acciona_wemob'
        ]);

        $vehicle->incrementKms($data->kms - $vehicle->kms);

        if ($data->chassis_hours) {
            $vehicle->incrementCanHours($data->chassis_hours - $vehicle->chassis_can_work_hours);
        }

        if ($data->power_takeoff_hours) {
            $vehicle->incrementEquipmentHours($data->power_takeoff_hours - $vehicle->equipment_work_hours);
        }

        $this->info($vehicle->plate . $data->kms . ' - ' . $data->chassis_hours . ' - ' . $data->power_takeoff_hours);
    }
}
