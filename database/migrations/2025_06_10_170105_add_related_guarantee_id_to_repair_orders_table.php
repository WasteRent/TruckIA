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
        Schema::table('repair_orders', function (Blueprint $table) {    
            $table->unsignedBigInteger('related_guarantee_id')->nullable();

            $table->foreign('related_guarantee_id')->references('id')->on('guarantees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repair_orders', function (Blueprint $table) {
            $table->dropColumn('related_guarantee_id');

            $table->dropForeign(['related_guarantee_id']);
        });
    }
};
