<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('container_checklist_work_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('container_checklist_id');
            $table->enum('line_type', ['labor', 'part']);
            $table->string('description');
            $table->decimal('time_in_hours', 8, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->timestamps();

            $table->foreign('container_checklist_id')->references('id')->on('container_checklists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('container_checklist_work_lines');
    }
};
