<?php

use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use Illuminate\Database\Seeder;

class OperationFamilyTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(OperationFamily::class, 10)->create()->each(function ($family) {
            factory(OperationSubfamily::class, rand(2, 5))->create([
                'family_id' => $family->id,
            ]);
        });
    }
}
