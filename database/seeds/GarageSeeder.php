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
            'address' => 'C/ Tomás Paredes',
            'state' => 'Vigo',
            'province' => 'Pontevedra',
            'zip' => '36208',
            'user_id' => 2
        ]);
    }
}
