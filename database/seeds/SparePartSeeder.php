<?php

use App\Models\SparePart;
use Illuminate\Database\Seeder;

class SparePartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(SparePart::class, 10)->create();
    }
}
