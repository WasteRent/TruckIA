<?php

namespace App\Jobs;

use App\Classes\AlertService;
use App\Models\AlertType;
use App\Models\Fleet;
use App\Models\Vehicle;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ItvAlertJob implements ShouldQueue
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
        $vehicles = Vehicle::active()->where('itv_date', '>', now())->get();
        $fleet = Fleet::first();

        foreach ($vehicles as $vehicle) {
            $days = Carbon::parse($vehicle->itv_date)->diffInDays();
            $action_url = "/fleet/repair-orders/create?vehicle_id={$vehicle->id}&type=pre-itv";

            if ($days == 30) {
                $this->alertService->to($fleet)->forVehicle($vehicle)->notify(
                    "ITV en 30 días",
                    "Vehículo cumple la ITV en 30 días",
                    $action_url,
                    AlertType::ITV
                );
            } else if ($days == 15) {
                $this->alertService->to($fleet)->forVehicle($vehicle)->notify(
                    "ITV en 15 días",
                    "Vehículo cumple la ITV en 15 días",
                    $action_url,
                    AlertType::ITV
                );
            }
        }
    }
}
