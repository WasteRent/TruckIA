<?php

namespace App\Jobs;

use App\Classes\TomTom\TomTomClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetVehiclesTrackingJob implements ShouldQueue
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
        $tomtom = app(TomTomClient::class);

        $data = $tomtom->executeAction("showObjectReportExtern");

        foreach ($data as $entry) {
            $vehicle = Vehicle::active()->where('webfleet_id', $entry['objectno'])->first();

            if (!$vehicle || !isset($entry['msgtime'])) {
                continue;
            }

            $message_uid = md5($entry['msgtime'] . $vehicle->plate);

            if (VehicleTracking::where('message_uid', $message_uid)->exists()) {
                continue;
            }

            $kms = $entry['odometer'] / 10;
            $can_minutes = isset($entry['engine_operating_time']) ? $entry['engine_operating_time']/60.0:null;

            VehicleTracking::create([
                'vehicle_id' => $vehicle->id,
                'message_uid' => $message_uid,
                'kms' => $kms,
                'engine_minutes' => $can_minutes,
                'fuel_level_percent' => isset($entry['fuellevel']) ? $entry['fuellevel'] / 10 : null,
                'address' => $entry['postext'],
                'latitude' => $entry['latitude_mdeg'] / 1000000,
                'longitude' => $entry['longitude_mdeg'] / 1000000,
                'fired_at' => Carbon::createFromFormat("d/m/Y H:i", $entry['msgtime'])->format('Y-m-d H:i:s')
            ]);

            $vehicle->incrementKms($kms - $vehicle->kms);

            if ($can_minutes) {
                $vehicle->incrementCanHours(($can_minutes / 60.0) - $vehicle->chassis_can_work_hours);
            }
        }
    }
}
