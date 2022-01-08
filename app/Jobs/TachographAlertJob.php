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

class TachographAlertJob implements ShouldQueue
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
        $vehicles = Vehicle::active()->where('last_tachograph_date', '<', now())->get();

        foreach ($vehicles as $vehicle) {
            $days = Carbon::parse($vehicle->last_tachograph_date)->diffInDays();

            if ($days == 30) {
                $this->alertService->to($vehicle->fleet)->forVehicle($vehicle)->notify(
                    "Revisión de tacógrafo en 30 días",
                    "Revisión de tacógrafo en 30 días",
                    null,
                    AlertType::ESTINGUISHER
                );
            } else if ($days == 15) {
                $this->alertService->to($vehicle->fleet)->forVehicle($vehicle)->notify(
                    "Revisión de tacógrafo en 15 días",
                    "Revisión de tacógrafo en 15 días",
                    null,
                    AlertType::ESTINGUISHER
                );
            }
        }
    }
}
