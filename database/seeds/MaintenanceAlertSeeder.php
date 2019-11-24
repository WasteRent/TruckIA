<?php

use App\Models\MaintenanceAlert;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class MaintenanceAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaintenanceAlert::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem'
        ]);

        MaintenanceAlert::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur'
        ]);

        MaintenanceAlert::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem'
        ]);

        MaintenanceAlert::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem'
        ]);

        MaintenanceAlert::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem'
        ]);

        MaintenanceAlert::create([
            'vehicle_id' => Vehicle::all()->random()->id,
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium dolorem'
        ]);
    }
}
