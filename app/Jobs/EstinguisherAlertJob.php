<?php

namespace App\Jobs;

use App\Classes\AlertService;
use App\Models\AlertType;
use App\Models\VehicleEstinguisher;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EstinguisherAlertJob implements ShouldQueue
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
        $estinguishers = VehicleEstinguisher::where('expiration_date', '>', now())->get();

        foreach ($estinguishers as $estinguisher) {
            $days = Carbon::parse($estinguisher->expiration_date)->diffInDays();

            if ($days == 30) {
                $this->alertService->to($estinguisher->vehicle->fleet)->forVehicle($estinguisher->vehicle)->notify(
                    "Extintor {$estinguisher->code} {$estinguisher->name}",
                    'Caduca extintor en 30 días',
                    null,
                    AlertType::ESTINGUISHER
                );
            } elseif ($days == 15) {
                $this->alertService->to($estinguisher->vehicle->fleet)->forVehicle($estinguisher->vehicle)->notify(
                    "Extintor {$estinguisher->code} {$estinguisher->name}",
                    'Caduca extintor en 15 días',
                    null,
                    AlertType::ESTINGUISHER
                );
            }
        }
    }
}
