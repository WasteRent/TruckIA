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
        Schema::create('vehicle_checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('checklist_id');
            $table->text('signature')->nullable();
            $table->text('notes')->nullable();
            $table->string('grid')->nullable();
            $table->json('positions')->nullable();
            $table->number('engine_hours')->nullable();
            $table->number('tdf_hours')->nullable();
            $table->date('date')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_checklists');
    }
};
