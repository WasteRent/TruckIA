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
                if ($plan->kms > 0) {
                    $vehicle->counters()->save(new VehicleWorkCounter([
                        'vehicle_category' => 'chassis',
                        'max' => $plan->kms,
                        'type' => 'kms',
                        'description' => $plan->name
                    ]));
                }
                if ($plan->natural_hours > 0) {
                    $vehicle->counters()->save(new VehicleWorkCounter([
                        'vehicle_category' => 'chassis',
                        'max' => $plan->natural_hours,
                        'type' => 'natural_hours',
                        'description' => $plan->name
                    ]));
                }
                if ($plan->can_hours > 0) {
                    $vehicle->counters()->save(new VehicleWorkCounter([
                        'vehicle_category' => 'equipment',
                        'max' => $plan->can_hours,
                        'type' => 'work_hours',
                        'description' => $plan->name
                    ]));
                }
                if ($plan->grua_hours > 0) {
                    $vehicle->counters()->save(new VehicleWorkCounter([
                        'vehicle_category' => 'equipment',
                        'max' => $plan->grua_hours,
                        'type' => 'grua_hours',
                        'description' => $plan->name
                    ]));
                }
            }
        }
    }
}
