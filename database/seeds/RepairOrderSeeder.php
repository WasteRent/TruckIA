<?php

use App\Models\RepairOrder;
use App\Models\RepairOrderOperation;
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
                'color' => RepairOrderState::STATE_COLORS[$id],
            ]);
        }

        factory(RepairOrder::class, 5)->create([
            'state_id' => RepairOrderState::all()->random()->first()->id,
        ])->each(function ($order) {
            $order->operations()->save(new RepairOrderOperation([
                'operation_family' => str_random(5),
                'operation_subfamily' => str_random(5),
                'operation_code' => str_random(5),
                'operation_name' => str_random(5),
                'operation_description' => str_random(15),
                'estimated_time_in_hours' => rand(1, 10),
            ]));
        });
    }
}
