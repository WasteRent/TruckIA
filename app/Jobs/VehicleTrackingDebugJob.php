<?php

namespace App\Jobs;

use App\Models\VehicleTrackingDebug;
use App\Services\VehicleTracking\VehicleTrackingFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class VehicleTrackingDebugJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $debug_id;

    public function __construct(int $debug_id)
    {
        $this->debug_id = $debug_id;
    }

    public function handle(VehicleTrackingFactory $factory): void
    {
        $debug = VehicleTrackingDebug::find($this->debug_id);

        if (! $debug) {
            return;
        }

        try {
            $service = $factory->getService($debug->provider);

            $rows = $service->getDataForService($debug->service_key, []);

            $debug->update([
                'status' => 'success',
                'response' => $rows,
                'error_message' => null,
            ]);
        } catch (Throwable $e) {
            $debug->update([
                'status' => 'error',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}

