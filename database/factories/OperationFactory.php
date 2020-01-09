<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Operation;
use App\Models\OperationSubfamily;
use Faker\Generator as Faker;

$factory->define(Operation::class, function (Faker $faker) {
    return [
        'code' => str_random(3),
        'name' => $faker->sentence,
        'description' => $faker->sentence,
        'time_in_hours' => rand(1, 7),
        'subfamily_id' => OperationSubfamily::all()->random()
    ];
});
