<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RepairOrderState;
use Faker\Generator as Faker;

$factory->define(RepairOrderState::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
