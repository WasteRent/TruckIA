<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Fleet;
use App\Models\Garage;
use App\Models\RepairOrder;
use App\Models\Vehicle;
use App\User;
use Faker\Generator as Faker;

$factory->define(RepairOrder::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['pre-itv', 'preventive', 'corrective']),
        'vehicle_id' => Vehicle::all()->random(),
        'garage_id' => Garage::all()->random(),
        'creator_user_id' => User::where('role', 'admin')->first()->id,
        'fleet_id' => Fleet::first()->id,
    ];
});
