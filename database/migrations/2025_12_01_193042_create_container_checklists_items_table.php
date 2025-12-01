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
        Schema::create('container_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checklist_item_id');
            $table->unsignedBigInteger('container_checklist_id');
            $table->boolean('is_checked')->default(false);
            $table->timestamps();

            $table->foreign('checklist_item_id')->references('id')->on('checklist_items')->onDelete('cascade');
            $table->foreign('container_checklist_id')->references('id')->on('container_checklists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_checklist_items');
    }
};
