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

class GetVehiclesPositionJob implements ShouldQueue
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
        $tomtom = new TomTomClient(
            config('tomtom.base_url'),
            config('tomtom.api_key'),
            config('tomtom.account'),
            config('tomtom.username'),
            config('tomtom.password')
        );

        $data = $tomtom->executeAction("showObjectReportExtern");

        foreach ($data as $entry) {
            $vehicle = Vehicle::where('plate', $entry['objectname'])->first();

            if (!$vehicle || VehicleTracking::where('object_uid', $entry['objectuid'])->exists()) {
                continue;
            }

            VehicleTracking::create([
                'vehicle_id' => $vehicle->id,
                'object_uid' => $entry['objectuid'],
                'kms' => $entry['odometer'] / 10,
                'engine_minutes' => isset($entry['engine_operating_time']) ? $entry['engine_operating_time']/6:null,
                'fuel_level_percent' => isset($entry['fuellevel']) ? $entry['fuellevel'] / 10 : null,
                'address' => $entry['postext'],
                'latitude' => $entry['latitude_mdeg'] / 1000000,
                'longitude' => $entry['longitude_mdeg'] / 1000000,
                'fired_at' => Carbon::createFromFormat("d/m/Y H:i", $entry['msgtime'])->format('Y-m-d H:i:s')
            ]);
        }
    }
}
