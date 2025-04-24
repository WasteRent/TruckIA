<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_washing_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        
        DB::table('vehicle_washing_types')->insert([
            ['name' => 'Lavado exterior', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Lavado interior', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Engrase', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_washing_types');
    }
}; 