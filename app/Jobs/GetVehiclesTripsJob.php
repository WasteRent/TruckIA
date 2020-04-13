<?php

namespace App\Jobs;

use App\Classes\TomTom\TomTomClient;
use App\Models\Vehicle;
use App\Models\VehicleTrip;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetVehiclesTripsJob implements ShouldQueue
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

        $data = $tomtom->executeAction("showTripReportExtern", [
            'range_pattern' => 'w0'
        ]);

        foreach ($data as $entry) {
            $vehicle = Vehicle::where('webfleet_id', $entry['objectno'])->first();

            if (!$vehicle) {
                continue;
            }

            VehicleTrip::updateOrCreate(
                ['vehicle_id' => $vehicle->id, 'trip_uid' => $entry['tripid']],
                [
                    'duration_minutes' => $entry['duration']/60.0,
                    'distance_kms' => $entry['distance']/1000,
                    'start_address' => $entry['start_postext'],
                    'end_address' => $entry['end_postext'],
                    'start_latitude' => $entry['start_latitude'] / 1000000,
                    'start_longitude' => $entry['start_longitude'] / 1000000,
                    'end_latitude' => $entry['end_latitude'] / 1000000,
                    'end_longitude' => $entry['end_longitude'] / 1000000,
                    'start_at' => Carbon::createFromFormat("d/m/Y H:i:s", $entry['start_time'])->format('Y-m-d H:i:s'),
                    'end_at' => Carbon::createFromFormat("d/m/Y H:i:s", $entry['end_time'])->format('Y-m-d H:i:s')
                ]
            );
        }
    }
}
