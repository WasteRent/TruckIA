<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Alert;
use App\Models\Fleet;
use App\Models\Vehicle;
use Faker\Generator as Faker;

$factory->define(Alert::class, function (Faker $faker) {
    return [
        'vehicle_id' => Vehicle::all()->random()->first()->id,
        'title' => $faker->word,
        'description' => $faker->paragraph,
        'fleet_id' => Fleet::first()->id,
    ];
});
