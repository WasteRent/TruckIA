<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OperationSubfamily;
use Faker\Generator as Faker;

$factory->define(OperationSubfamily::class, function (Faker $faker) {
    return [
        'family_id' => null,
        'name' => $faker->word,
    ];
});
