<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MaintenancePlanSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(GarageSeeder::class);
        $this->call(OperationSeeder::class);
        $this->call(MaintenanceAlertSeeder::class);
        $this->call(UserSeeder::class);
    }
}
