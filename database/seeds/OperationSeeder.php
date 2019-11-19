<?php

use App\Models\Garage;
use App\Models\MaintenancePlan;
use App\Models\Vehicle;
use App\Operation;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operation::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'garage_id' => Garage::all()->random()->id,
            'maintenance_plan_id' => MaintenancePlan::all()->random()->id,
        ]);
        Operation::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'garage_id' => Garage::all()->random()->id,
            'maintenance_plan_id' => MaintenancePlan::all()->random()->id,
        ]);
    }
}
