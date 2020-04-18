<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreventiveOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preventive_operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('preventive_id');
            $table->string('operation_family');
            $table->string('operation_subfamily');
            $table->string('operation_code');
            $table->string('operation_name');
            $table->text('operation_description')->nullable();
            $table->text('observations')->nullable();
            $table->unsignedBigInteger('file_id')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('preventive_id')->references('id')->on('preventives');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preventive_operations');
    }
}
