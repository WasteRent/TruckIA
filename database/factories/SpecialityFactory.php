<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Speciality;
use Faker\Generator as Faker;

$factory->define(Speciality::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
