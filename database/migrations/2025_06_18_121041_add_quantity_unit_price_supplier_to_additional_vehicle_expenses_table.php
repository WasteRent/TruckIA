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
        Schema::table('additional_vehicle_expenses', function (Blueprint $table) {
            $table->integer('quantity')->nullable();
            $table->decimal('unit_price', 8, 2)->nullable();
            $table->string('supplier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_vehicle_expenses', function (Blueprint $table) {
            $table->dropColumn(['quantity', 'unit_price', 'supplier']);
        });
    }
};
