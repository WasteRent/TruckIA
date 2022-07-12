<?php

use App\Models\Alert;
use App\Models\AlertType;
use App\User;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (AlertType::TYPES as $id => $name) {
            AlertType::create([
                'id' => $id,
                'name' => $name,
            ]);
        }

        User::all()->each(function ($user) {
            if ($user->hasRole('fleet')) {
                factory(Alert::class)->create(['fleet_id' => $user->fleet->id]);
            } elseif ($user->hasRole('garage')) {
                factory(Alert::class)->create(['garage_id' => $user->garage->id]);
            } elseif ($user->hasRole('customer')) {
                factory(Alert::class)->create(['customer_id' => $user->customer->id]);
            }
        });
    }
}
