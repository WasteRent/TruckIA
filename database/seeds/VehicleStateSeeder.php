<?php

use App\Models\VehicleState;
use Illuminate\Database\Seeder;

class VehicleStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleState::create(['name' => 'Baja']);
        VehicleState::create(['name' => 'Vendido']);
        VehicleState::create(['name' => 'Alquilado']);
        VehicleState::create(['name' => 'Disponible']);
        VehicleState::create(['name' => 'Pdt. Revisión']);
        VehicleState::create(['name' => 'Revisado']);
    }
}
