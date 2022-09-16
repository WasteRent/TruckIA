<?php

namespace App\Jobs;

use App\Classes\AlertService;
use App\Models\AlertType;
use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class VehicleInGarageAlertJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $alertService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->alertService = new AlertService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Vehicle::active()->where('state_id', VehicleState::GARAGE)
            ->get()
            ->filter(function($vehicle) {
                return $vehicle->stateHistory()->where('state_id', VehicleState::GARAGE)->exists();
            })->filter(function($vehicle) {
                return $vehicle->stateHistory()->where('state_id', VehicleState::GARAGE)->latest()->first()->created_at->diffInDays() == 4;
            })->each(function($vehicle) {
                $this->alertService->to($vehicle->fleet)->forVehicle($vehicle)->notify(
                    'Taller',
                    'Vehículo lleva más de 4 días en taller',
                    "/fleet/vehicles/{$vehicle->id}",
                    AlertType::VEHICLE_STATE_CHANGED
                );
            });
    }
}
