<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OperationFamily;
use Faker\Generator as Faker;

$factory->define(OperationFamily::class, function (Faker $faker) {
    return [
        'name' => $faker->word
    ];
});
