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
            foreach ($vehicle->counters as $counter) {
                $this->sync($vehicle, $counter);
            }
        }
    }

    private function sync(Vehicle $vehicle, $counter) {
        $last_prev = $vehicle->repairOrders()
                        ->where('type', 'preventive')
                        ->where('state_id', RepairOrderState::FINISHED)
                        ->whereHas('operations', function($q) use ($counter) {
                            $q->where('maintenance_plan_id', $counter->plan_id);
                        })
                        ->latest()
                        ->first();

        if ($counter->vehicle_category == 'equipment' && $counter->type == 'work_hours') {
            $value = $last_prev 
                        ? max($vehicle->equipment_work_hours - $last_prev->work_hours_equipment, 0)
                        : $vehicle->equipment_work_hours;
            echo " - Equipment $counter->type $counter->max : $value\n";
        }
        else if ($counter->vehicle_category == 'chassis' && $counter->type == 'work_hours') {
            $value = $last_prev
                        ? max($vehicle->chassis_can_work_hours - $last_prev->work_hours_chassis, 0)
                        : $vehicle->chassis_can_work_hours;
            echo " - Chassis $counter->type $counter->max : $value\n";
        }
        else if ($counter->vehicle_category == 'chassis' && $counter->type == 'kms') {
            $value = $last_prev 
                        ? max($vehicle->kms - $last_prev->kms, 0)
                        : $vehicle->kms;
            echo " - Chassis $counter->type $counter->max : $value\n";
        }
        else if ($counter->type == 'natural_hours') {
            $value = $last_prev 
                        ? max($last_prev->created_at->diffInHours(), 0)
                        : $counter->current;
            echo " - $counter->type $counter->max : $value\n";
        }

        if (isset($value)) {
            $counter->update(['current' => $value]);
        }
    }
}
