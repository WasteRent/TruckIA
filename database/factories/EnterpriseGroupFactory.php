<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\EnterpriseGroup;
use App\Models\Fleet;
use Faker\Generator as Faker;

$factory->define(EnterpriseGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'fleet_id' => Fleet::first()->id,
    ];
});
