<?php

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
        User::create([
            'id' => 1,
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => str_random(10),
            'name' => 'Admin',
            'is_active' => 1,
            'role' => 'admin'
        ]);
        User::create([
            'id' => 2,
            'username' => 'taller',
            'password' => bcrypt('taller'),
            'email' => str_random(10),
            'name' => 'Taller',
            'is_active' => 1,
            'role' => 'garage'
        ]);
        User::create([
            'id' => 3,
            'username' => 'flota',
            'password' => bcrypt('flota'),
            'email' => str_random(10),
            'name' => 'Flota',
            'is_active' => 1,
            'role' => 'fleet'
        ]);
    }
}
