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
        Schema::create('repair_order_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_order_id');
            $table->unsignedBigInteger('checklist_id');
            $table->text('signature')->nullable();
            $table->text('notes')->nullable();
            $table->string('grid')->nullable();
            $table->json('positions')->nullable();
            $table->timestamps();

            $table->foreign('repair_order_id')->references('id')->on('repair_orders')->onDelete('cascade');
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('repair_order_checklists');
    }
};
