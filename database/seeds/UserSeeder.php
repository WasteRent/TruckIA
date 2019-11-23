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
            'role' => 'admin'
        ]);
        User::create([
            'id' => 2,
            'username' => 'taller',
            'password' => bcrypt('taller'),
            'email' => str_random(10),
            'name' => 'Taller',
            'role' => 'garage'
        ]);
        User::create([
            'id' => 3,
            'username' => 'flota',
            'password' => bcrypt('flota'),
            'email' => str_random(10),
            'name' => 'Flota',
            'role' => 'fleet'
        ]);
    }
}
