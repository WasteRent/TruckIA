<?php

use App\Models\Fleet;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use App\Models\VehicleTracking;
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
        factory(Manufacturer::class, 5)->create()->each(function ($manufacturer) {
            factory(Model::class, 3)->create(['manufacturer_id' => $manufacturer->id]);
        });


        Vehicle::create([
            'plate' => '1111AAA',
            'registration_date' => '2011-11-07',
            'kms' => 271922,
            'chassis_maker_id' => Manufacturer::all()->random()->id,
            'chassis_model_id' => Model::all()->random()->id
        ]);

        Vehicle::create([
            'plate' => '2222BBB',
            'registration_date' => '2017-11-07',
            'kms' => 12122,
            'chassis_maker_id' => Manufacturer::all()->random()->id,
            'chassis_model_id' => Model::all()->random()->id
        ]);

        VehicleTracking::create([
            'vehicle_id' => 1,
            'message_uid' => str_random(10),
            'kms' => 10000,
            'engine_minutes' => 20123,
            'fuel_level_percent' => 73,
            'address' => 'Moshtoles',
            'latitude' => "40.293214",
            'longitude' => "-3.695634",
            'fired_at' => new \DateTime
        ]);
        VehicleTracking::create([
            'vehicle_id' => 2,
            'message_uid' => str_random(10),
            'kms' => 12000,
            'engine_minutes' => 201123,
            'fuel_level_percent' => 33,
            'address' => 'Moshtoles',
            'latitude' => "40.293214",
            'longitude' => "-3.695634",
            'fired_at' => new \DateTime
        ]);
    }
}
