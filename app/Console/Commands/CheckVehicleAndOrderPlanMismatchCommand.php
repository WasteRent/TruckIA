<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Vehicle;

class CheckVehicleAndOrderPlanMismatchCommand extends Command
{
    protected $signature = 'check:vehicle-and-order-plan-mismatch {fleet_id}';

    protected $description = 'Check for vehicle and order plan mismatch';

    public function handle()
    {
        $fleet_id = $this->argument('fleet_id');
        $vehicles = Vehicle::where('fleet_id', $fleet_id)->whereHas('repairOrders')->whereHas('counters')->get();
        foreach($vehicles as $vehicle) {
            foreach($vehicle->repairOrders()->whereNotNull('finished_at')->cursor() as $repairOrder) {
                $repair_order_plans = $repairOrder->operations->pluck('maintenance_plan_id')->unique()->values()->toArray();
                $vehicle_plans = $vehicle->counters->pluck('plan_id')->unique()->values()->toArray();

                if(count($repair_order_plans) > 0) {
                    $missing_plans = array_filter(array_diff($repair_order_plans, $vehicle_plans));
                    if (count($missing_plans) > 0) {
                        $this->info("Vehicle {$vehicle->plate} has repair order plans " . implode(',', $missing_plans) . " that are not in vehicle counters");
                    }
                }
            }
        }
    }
}
