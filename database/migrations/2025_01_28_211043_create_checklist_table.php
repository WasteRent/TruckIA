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
        Schema::create('vehicle_checklist_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->boolean('technical_sheet')->nullable(); 
            $table->boolean('vehicle_registration')->nullable(); 
            $table->boolean('equipment_manual')->nullable(); 
            $table->timestamps();
            $table->foreign('vehicle_id')
            ->references('id')
            ->on('vehicles')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checklist');
    }
};
