<?php

use App\Models\Operation;
use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use Illuminate\Database\Seeder;

class RepairOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (RepairOrderState::STATES as $id => $name) {
            factory(RepairOrderState::class)->create([
                'id' => $id,
                'name' => $name,
                'color' => RepairOrderState::STATE_COLORS[$id]
            ]);
        }
        
        factory(RepairOrder::class, 5)->create([
            'state_id' => RepairOrderState::all()->random()->first()->id
        ])->each(function ($order) {
            $order->operations()->saveMany(Operation::all()->take(rand(3, 8)));
        });
    }
}
