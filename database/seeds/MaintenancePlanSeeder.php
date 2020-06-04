<?php

use App\Models\MaintenancePlan;
use App\Models\Operation;
use Illuminate\Database\Seeder;

class MaintenancePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MaintenancePlan::class, 3)->create()->each(function ($plan) {
            //$plan->operations()->saveMany(Operation::all()->take(rand(3, 8)));
        });
    }
}
