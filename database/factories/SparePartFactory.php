<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SparePart;
use Faker\Generator as Faker;

$factory->define(SparePart::class, function (Faker $faker) {
    $reference = $faker->word;
    return [
        'reference' => $reference,
        'short_reference' => $reference,
        'description' => $faker->sentence,
        'price' => $faker->randomFloat(2, 4, 1000)
    ];
});
