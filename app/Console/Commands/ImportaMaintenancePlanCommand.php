<?php

namespace App\Console\Commands;

use App\Models\Fleet;
use App\Models\MaintenancePlan;
use App\Models\MaintenancePlanOperation;
use App\Models\OperationFamily;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;


class ImportaMaintenancePlanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance-plan:import {fleet_id} {plates} {prefix_plan_name}';

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
        $plates = explode(',', $this->argument('plates'));
        $fleet = Fleet::find($this->argument('fleet_id'));
        $plans = MaintenancePlan::whereHas('fleet', function($query) use ($fleet) {
            $query->where('fleet_id', $fleet->id);
        })->where('name', 'LIKE', $this->argument('prefix_plan_name').'%')->get();

        $this->info($plans->count());

        if($plans->count() == 0) {
            $this->error('No se encontraron planes');
            return;
        }

        try {
            DB::beginTransaction();

            foreach ($plates as $plate) {
                $vehicle = Vehicle::where('plate', $plate)->where('fleet_id', $fleet->id)->firstOrFail();

                $vehicle->counters()->delete();

                foreach($plans as $plan) {
                    if ($plan->kms > 0) {
                        $vehicle->counters()->save(new VehicleWorkCounter([
                            'plan_id' => $plan->id,
                            'vehicle_category' => $plan->vehicle_category,
                            'max' => $plan->kms,
                            'type' => 'kms',
                            'description' => $plan->fullname,
                        ]));
                    }
                    if ($plan->natural_hours > 0) {
                        $vehicle->counters()->save(new VehicleWorkCounter([
                            'plan_id' => $plan->id,
                            'vehicle_category' => $plan->vehicle_category,
                            'max' => $plan->natural_hours,
                            'type' => 'natural_hours',
                            'description' => $plan->fullname,
                        ]));
                    }
                    if ($plan->work_hours > 0) {
                        $vehicle->counters()->save(new VehicleWorkCounter([
                            'plan_id' => $plan->id,
                            'vehicle_category' => $plan->vehicle_category,
                            'max' => $plan->work_hours,
                            'type' => 'work_hours',
                            'description' => $plan->fullname,
                        ]));
                    } elseif ($plan->can_hours > 0) {
                        $vehicle->counters()->save(new VehicleWorkCounter([
                            'plan_id' => $plan->id,
                            'vehicle_category' => $plan->vehicle_category,
                            'max' => $plan->can_hours,
                            'type' => 'work_hours',
                            'description' => $plan->fullname,
                        ]));
                    }
                }

                Artisan::call("maintenance:sync {$vehicle->id}");
                $this->info($vehicle->plate);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
