<?php

namespace App\Jobs;

use App\Classes\GoogleMaps\GeocodeClient;
use App\Classes\WeMob\WeMobClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetVehiclesTrackingWeMobJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $wemob = app(WeMobClient::class);

        foreach ($wemob->getData() as $data) {
            $this->updateData($data);
            echo "$data->plate";
        }
    }

    private function updateData($data)
    {
        $maps = app(GeocodeClient::class);

        $vehicle = Vehicle::active()->where('plate', $data->plate)->where('fleet_id', 2)->first();

        if (!$vehicle) {
            return;
        }

        $message_uid = md5($data->plate . $data->timestamp);

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
            'fired_at' => date('Y-m-d H:i:s', $data->timestamp / 1000)
        ]);

        $vehicle->incrementKms($data->kms - $vehicle->kms);
        
        if ($data->chassis_hours) {
            $vehicle->incrementCanHours($data->chassis_hours - $vehicle->chassis_can_work_hours);
        }
    }
}
