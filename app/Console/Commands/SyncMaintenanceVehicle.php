<?php

namespace App\Console\Commands;

use App\Models\RepairOrderState;
use App\Models\Vehicle;
use Illuminate\Console\Command;

class SyncMaintenanceVehicle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:sync {vehicle?}';

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
            $last_prev = $vehicle->repairOrders()->where('type', 'preventive')->where('state_id', RepairOrderState::FINISHED)->latest()->first();

            if ($last_prev) {
                echo "veh: $vehicle->plate OR $last_prev->id \n";

                $operations = $last_prev->operations()->pluck('maintenance_plan_id')->unique()->toArray();
                $chassis_diff = max($vehicle->chassis_can_work_hours - $last_prev->work_hours_chassis, 0);
                $equipment_diff = max($vehicle->equipment_work_hours - $last_prev->work_hours_equipment, 0);

                foreach ($vehicle->counters()->whereIn('type', ['work_hours', 'kms'])->get() as $counter) {
                    if (in_array($counter->plan_id, $operations)) {
                        if($counter->vehicle_category == 'chassis') {
                            //$counter->update(['current' => $chassis_diff]);
                            echo "chassis $counter->id : $chassis_diff\n";
                        } elseif($counter->vehicle_category == 'equipment') {
                            //$counter->update(['current' => $equipment_diff]);
                            echo "equipment $counter->id : $equipment_diff\n";
                        }
                    }
                }

                echo "--------------------\n";
            }
        }
    }
}
