<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'contact1' => $faker->word,
        'email1' => $faker->email,
        'phone1' => $faker->word,
        'address' => $faker->address
    ];
});
