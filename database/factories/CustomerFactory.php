<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->email,
        'phone' => $faker->word,
        'address' => $faker->address
    ];
});
