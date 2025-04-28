<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_washing_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_washing_id')->constrained('vehicle_washings')->onDelete('cascade');
            $table->foreignId('vehicle_washing_type_id')->constrained('vehicle_washing_types')->onDelete('cascade');
            $table->boolean('is_checked')->default(false);
            $table->timestamps();

            $table->unique(
                ['vehicle_washing_id', 'vehicle_washing_type_id'],
                'vw_checklist_unique'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_washing_checklists');
    }
};
