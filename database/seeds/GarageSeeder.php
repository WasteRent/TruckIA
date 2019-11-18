<?php

use App\Models\Garage;
use Illuminate\Database\Seeder;

class GarageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Garage::create([
            'name' => 'Talleres García Barriero SL',
            'email' => 'taller@garciabarreiro.es',
            'phone' => '986 46 94 25',
            'address' => 'C/ Tomás Paredes',
            'state' => 'Vigo',
            'province' => 'Pontevedra',
            'zip' => '36208'
        ]);
    }
}
