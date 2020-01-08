<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use Faker\Generator as Faker;

$factory->define(RepairOrder::class, function (Faker $faker) {
    return [
        'vehicle_id' => Vehicle::all()->random(),
        'garage_id' => Garage::all()->random()
    ];
});
