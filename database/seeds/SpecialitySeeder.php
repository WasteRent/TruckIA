<?php

use App\Models\Garage;
use App\Models\Speciality;
use Illuminate\Database\Seeder;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Speciality::class, 4)->create();

        Garage::all()->each(function ($garage) {
            $garage->specialities()->attach(Speciality::all());
        });
    }
}
