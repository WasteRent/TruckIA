<?php

use App\Models\Operation;
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
                'color' => RepairOrderState::STATE_COLORS[$id]
            ]);
        }
        
        factory(RepairOrder::class, 5)->create([
            'state_id' => RepairOrderState::all()->random()->first()->id
        ])->each(function ($order) {
            Operation::all()->take(rand(3, 8))->each(function ($operation) use ($order) {
                $order->operations()->save(new RepairOrderOperation([
                    'operation_family' => $operation->family->name,
                    'operation_subfamily' => $operation->subfamily->name,
                    'operation_code' => $operation->code,
                    'operation_name' => $operation->name,
                    'operation_description' => $operation->description,
                    'estimated_time_in_hours' => $operation->time_in_hours
                ]));
            });
        });
    }
}
