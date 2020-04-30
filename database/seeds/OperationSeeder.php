<?php

use App\Models\Operation;
use Illuminate\Database\Seeder;

class OperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Operation::disableSearchSyncing();

        factory(Operation::class, 20)->create();

        Operation::enableSearchSyncing();
    }
}
