<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('vehicle_checklist_file_types')->insert([
            ['name' => 'Ficha técnica', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Permiso de circulación', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Manual de equipo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Certificado europeo', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Seguro', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
