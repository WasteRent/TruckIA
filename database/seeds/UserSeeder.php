<?php

use App\Models\Alert;
use App\Models\AlertType;
use App\Models\Customer;
use App\Models\Fleet;
use App\Models\Garage;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fleet = factory(Fleet::class)->create();
        $garage = Garage::create([
            'fleet_id' => Fleet::first()->id,
            'name' => 'Talleres García Barriero SL',
            'address' => 'C/ Tomás Paredes',
            'state' => 'Vigo',
            'province' => 'Pontevedra',
            'zip' => '36208'
        ]);
        $customer = factory(Customer::class)->create();

        User::create([
            'id' => 1,
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => 'lala@lynx.com',
            'name' => 'Admin',
            'is_active' => 1,
            'role' => 'admin',
            'entity_relation_id' => null
        ]);
        User::create([
            'id' => 2,
            'username' => 'taller',
            'password' => bcrypt('taller'),
            'email' => str_random(10),
            'name' => 'Taller',
            'is_active' => 1,
            'role' => 'garage',
            'entity_relation_id' => $garage->id
        ]);
        User::create([
            'id' => 3,
            'username' => 'flota',
            'password' => bcrypt('flota'),
            'email' => str_random(10),
            'name' => 'Flota',
            'is_active' => 1,
            'role' => 'fleet',
            'entity_relation_id' => $fleet->id
        ]);
        User::create([
            'id' => 4,
            'username' => 'cliente',
            'password' => bcrypt('cliente'),
            'email' => str_random(10),
            'name' => 'Cliente',
            'is_active' => 1,
            'role' => 'customer',
            'entity_relation_id' => $customer->id
        ]);
    }
}
