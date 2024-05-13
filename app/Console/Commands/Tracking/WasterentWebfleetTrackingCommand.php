<?php

namespace App\Console\Commands\Tracking;

use App\Classes\TomTom\TomTomClient;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
use App\Models\VehicleTrip;
use Carbon\Carbon;
use Illuminate\Console\Command;

class WasterentWebfleetTrackingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tracking:wasterent-webfleet';

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
        $this->getTracks();
        $this->getTrips();
    }

    private function getTracks()
    {
        $tomtom = new TomTomClient(
            config('services.tomtom.wasterent.base_url'),
            config('services.tomtom.wasterent.api_key'),
            config('services.tomtom.wasterent.account'),
            config('services.tomtom.wasterent.username'),
            config('services.tomtom.wasterent.password'),
        );

        $data = $tomtom->executeAction('showObjectReportExtern');

        foreach ($data as $entry) {
            $vehicle = Vehicle::active()->where('webfleet_id', $entry['objectno'])->first();

            if (! $vehicle || ! isset($entry['msgtime'])) {
                continue;
            }

            $message_uid = md5($entry['msgtime'].$vehicle->plate);

            if (VehicleTracking::where('message_uid', $message_uid)->exists()) {
                continue;
            }

            $kms = isset($entry['odometer']) ? $entry['odometer'] / 10 : 0;
            $can_minutes = isset($entry['engine_operating_time']) ? $entry['engine_operating_time'] / 60.0 : null;

            try {
                VehicleTracking::create([
                    'vehicle_id' => $vehicle->id,
                    'message_uid' => $message_uid,
                    'kms' => $kms,
                    'engine_minutes' => $can_minutes,
                    'fuel_level_percent' => isset($entry['fuellevel']) ? $entry['fuellevel'] / 10 : null,
                    'address' => isset($entry['postext']) ? $entry['postext'] : '',
                    'latitude' => $entry['latitude_mdeg'] / 1000000,
                    'longitude' => $entry['longitude_mdeg'] / 1000000,
                    'fired_at' => Carbon::createFromFormat('d/m/Y H:i', $entry['msgtime'])->format('Y-m-d H:i:s'),
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            $vehicle->incrementKms((int) ($kms - $vehicle->kms));

            if ($can_minutes) {
                $vehicle->incrementCanHours(($can_minutes / 60.0) - $vehicle->chassis_can_work_hours);
            }

            $this->info($vehicle->plate);
        }
    }

    private function getTrips()
    {
        $tomtom = new TomTomClient(
            config('services.tomtom.wasterent.base_url'),
            config('services.tomtom.wasterent.api_key'),
            config('services.tomtom.wasterent.account'),
            config('services.tomtom.wasterent.username'),
            config('services.tomtom.wasterent.password'),
        );

        $data = $tomtom->executeAction('showTripSummaryReportExtern', [
            'range_pattern' => 'd-2',
        ]);

        foreach ($data as $entry) {
            $vehicle = Vehicle::active()->where('webfleet_id', trim($entry['objectno']))->first();

            if (! $vehicle) {
                continue;
            }

            $trip_uid = md5($entry['start_time'].$vehicle->plate);

            if (VehicleTrip::where('trip_uid', $trip_uid)->exists()) {
                continue;
            }

            $duration_seconds = $entry['triptime'] - $entry['standstill'];
            VehicleTrip::create([
                'vehicle_id' => $vehicle->id,
                'trip_uid' => $trip_uid,
                'duration_seconds' => $duration_seconds,
                'distance_kms' => $entry['distance'] / 1000,
                'start_at' => Carbon::createFromFormat('d/m/Y H:i:s', $entry['start_time'])->format('Y-m-d H:i:s'),
                'end_at' => Carbon::createFromFormat('d/m/Y H:i:s', $entry['end_time'])->format('Y-m-d H:i:s'),
            ]);

            $vehicle->incrementGpsHours($duration_seconds / 3600.0);
        }
    }
}
