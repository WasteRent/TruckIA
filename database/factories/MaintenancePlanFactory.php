<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MaintenancePlan;
use Faker\Generator as Faker;

$factory->define(MaintenancePlan::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'frequency' => '300hrs'
    ];
});
