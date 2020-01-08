<?php

use App\Models\Operation;
use App\Models\RepairOrder;
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
        factory(RepairOrder::class, 5)->create()->each(function ($order) {
            $order->operations()->saveMany(Operation::all()->take(rand(3, 8)));
        });
    }
}
