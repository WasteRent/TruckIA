<?php

namespace App\Jobs;

use App\Classes\AlertService;
use App\Models\AlertType;
use App\Models\Fleet;
use App\Models\VehicleWorkCounter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MaintenanceAlertJob implements ShouldQueue
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
        $alertService = new AlertService;

        foreach (VehicleWorkCounter::all() as $counter) {
            $remaining = $counter->max - $counter->current;
            if ($counter->vehicle->isActive() && $counter->max > 200 && $remaining <= 100 && !$counter->notified) {
                $action_url = "/fleet/repair-orders/create?vehicle_id={$counter->vehicle->id}&type=corrective";

                $alertService->to($counter->vehicle->fleet)->forVehicle($counter->vehicle)->notify(
                    "Quedan 100H para el mantenimiento",
                    "Vehículo cumple mantenimiento de las {$counter->max}H",
                    $action_url,
                    AlertType::MAINTENANCE
                );

                $counter->update(['notified' => true]);
            }
        }
    }
}
