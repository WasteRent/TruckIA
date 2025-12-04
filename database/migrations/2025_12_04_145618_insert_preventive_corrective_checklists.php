<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::table('checklists')->insert([
            'id' => 7,
            'fleet_id' => 1,
            'name' => 'Preventivo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('checklists')->insert([
            'id' => 8,
            'fleet_id' => 1,
            'name' => 'Correctivo',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('checklists')->whereIn('id', [7, 8])->delete();
    }
};
