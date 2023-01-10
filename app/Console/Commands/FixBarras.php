<?php

namespace App\Console\Commands;

use App\Models\MaintenancePlan;
use App\Models\Vehicle;
use App\Models\VehicleWorkCounter;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FixBarras extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:barras {vehicle?}';

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
        $vehicles = $this->argument('vehicle') ? Vehicle::whereId($this->argument('vehicle'))->get() : Vehicle::all();

        foreach($vehicles as $vehicle) {
            $this->info($vehicle->plate);
            $this->fix($vehicle);
        }
    }

    private function fix(Vehicle $vehicle) {
        DB::beginTransaction();

        try {
            $this->resetBars($vehicle);
            $this->fixOrders($vehicle);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function fixOrders(Vehicle $vehicle) {
        $orders = $vehicle->repairOrders()->with('operations')->where('type', 'preventive')->get();

        foreach ($orders as $order) {
            $order_plans = $order->operations->pluck('maintenance_plan_name', 'maintenance_plan_id');
            $vehicle_plans = $vehicle->counters->pluck('plan_id');

            foreach ($order_plans as $order_plan_id => $order_plan_name) {
                if (!$vehicle_plans->contains($order_plan_id)) {
                    $preffix = trim(explode('-', $order_plan_name)[0] ?? null) . ' -';

                    $guess = MaintenancePlan::whereIn('id', $vehicle_plans)->where('name', 'like', "$preffix%")->first();

                    if ($guess) {
                        $order->operations()->where('maintenance_plan_id', $order_plan_id)->update([
                            'maintenance_plan_id' => $guess->id,
                            'maintenance_plan_name' => $guess->name
                        ]);
                        $this->info($guess->name);
                    }
                }

            }
        }
    }

    private function resetBars(Vehicle $vehicle) {
        $vehicle->counters()->delete();

        $plans = $vehicle->getMaintenancePlans();

        foreach ($plans as $plan) {
            if (Str::contains(strtolower($plan->name), ['diario', 'semanal', 'mensual', 'quincenal', 'primeras', 'primer'])) {
                continue;
            }

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
            }
        }
    }
}
