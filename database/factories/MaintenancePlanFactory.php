<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use App\Models\Model;
use Faker\Generator as Faker;

$factory->define(MaintenancePlan::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'frequency' => '300hrs',
        'frequency_type' => 'Horas',
        'model_id' => Model::all()->random(),
        'manufacturer_id' => Manufacturer::all()->random()
    ];
});
