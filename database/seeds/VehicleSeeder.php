<?php

use App\Models\Fleet;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::create([
            'fleet_id' => Fleet::all()->random()->first()->id,
            'plate' => '1111AAA',
            'registration_date' => '2011-11-07',
            'kms' => 271922,
            'chassis_maker' => 'DAF',
            'chassis_model' => 'CF 85.460',
            'box_maker' => 'FAUN',
            'box_model' => 'Variopress'
        ]);

        Vehicle::create([
            'fleet_id' => Fleet::all()->random()->first()->id,
            'plate' => '2222BBB',
            'registration_date' => '2017-11-07',
            'kms' => 12122,
            'chassis_maker' => 'RENAULT',
            'chassis_model' => 'MAGNUM',
            'box_maker' => 'RosRoca',
            'box_model' => 'Rotopress'
        ]);
    }
}
