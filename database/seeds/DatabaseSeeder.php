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
        $this->call(UserSeeder::class);
        $this->call(SparePartSeeder::class);
        $this->call(FleetSeeder::class);
        $this->call(VehicleSeeder::class);
        $this->call(GarageSeeder::class);
        $this->call(OperationFamilyTreeSeeder::class);
        $this->call(OperationSeeder::class);
        $this->call(MaintenanceAlertSeeder::class);
        $this->call(RepairOrderSeeder::class);
        $this->call(MaintenancePlanSeeder::class);
    }
}
