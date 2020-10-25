<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Fleet;
use App\Models\Manufacturer;
use App\Models\Model;
use App\Models\Vehicle;
use Faker\Generator as Faker;

$factory->define(Vehicle::class, function (Faker $faker) {
    return [
        'plate' => str_random(5),
        'chassis_maker_id' => Manufacturer::all()->random()->first()->id,
        'chassis_model_id' => Model::all()->random()->first()->id,
        'fleet_id' => Fleet::first()->id,
    ];
});
