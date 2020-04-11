<?php

namespace App\Jobs;

use App\Classes\AlertService;
use App\Models\AlertType;
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
        $vehicles = Vehicle::where('itv_date', '>', now())->get();

        foreach ($vehicles as $vehicle) {
            $days = Carbon::parse($vehicle->itv_date)->diffInDays();
            if ($days == 30) {
                $this->sendAlert($vehicle, 30);
            } else if ($days == 15) {
                $this->sendAlert($vehicle, 15);
            }
        }
    }

    private function sendAlert(Vehicle $vehicle, int $days)
    {
        User::where('role', 'fleet')->get()->each(function ($user) use ($days, $vehicle) {
            (new AlertService)->notify(
                $user->id,
                $vehicle->id,
                "ITV en $days días",
                "Vehículo cumple la ITV en $days días",
                AlertType::ITV
            );
        });
    }
}
