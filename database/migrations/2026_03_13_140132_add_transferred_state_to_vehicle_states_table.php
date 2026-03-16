<?php

use App\Models\VehicleState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('vehicle_states')->insert([
            'id' => VehicleState::TRANSFERRED,
            'name' => 'Cesión',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('vehicle_states')->where('id', 14)->delete();
    }
};
