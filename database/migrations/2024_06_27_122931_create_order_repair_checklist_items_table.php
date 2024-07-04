<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('repair_order_checklist_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_order_checklist_id');
            $table->unsignedBigInteger('checklist_item_id');
            $table->enum('result', ['bien', 'mal', 'regular']);
            $table->timestamps();

            $table->foreign('repair_order_checklist_id')->references('id')->on('repair_order_checklists')->onDelete('cascade');
            $table->foreign('checklist_item_id')->references('id')->on('checklist_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('repair_order_checklist_items');
    }
};
