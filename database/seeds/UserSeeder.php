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
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'email' => str_random(10),
            'name' => 'Admin',
            'role' => 'admin'
        ]);
        User::create([
            'username' => 'taller',
            'password' => bcrypt('taller'),
            'email' => str_random(10),
            'name' => 'Taller',
            'role' => 'garage'
        ]);
        User::create([
            'username' => 'flota',
            'password' => bcrypt('flota'),
            'email' => str_random(10),
            'name' => 'Flota',
            'role' => 'fleet'
        ]);
    }
}
