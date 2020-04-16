<?php

namespace App\Console\Commands;

use App\Models\MaintenancePlan;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;
use Illuminate\Console\Command;

class SyncMaintenancePlanCounters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:sync-counters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (Vehicle::all() as $vehicle) {
            foreach ($vehicle->getMaintenancePlans() as $plan) {
                if ($plan->can_hours == 0 && $plan->work_hours == 0) {
                    continue;
                }

                $hours = $plan->can_hours ?? $plan->work_hours;

                VehicleWorkCounter::firstOrCreate([
                    'max' => $hours,
                    'vehicle_id' => $vehicle->id,
                    'type' => 'hours'
                ]);
            }
        }
    }
}
