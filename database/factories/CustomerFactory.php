<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use App\Models\EnterpriseGroup;
use App\Models\Fleet;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'enterprise_group_id' => factory(EnterpriseGroup::class)->create(),
        'name' => $faker->company,
        'contact1' => $faker->word,
        'email1' => $faker->email,
        'phone1' => $faker->word,
        'address' => $faker->address,
        'fleet_id' => Fleet::first()->id,
    ];
});
