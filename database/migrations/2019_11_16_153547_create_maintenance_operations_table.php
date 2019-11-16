<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('maintenance_plan_id');
            $table->unsignedBigInteger('operation_type_id');
            $table->string('name');
            $table->string('acceptance');
            $table->timestamps();

            $table->foreign('maintenance_plan_id')->references('id')->on('maintenance_plans');
            $table->foreign('operation_type_id')->references('id')->on('maintenance_operation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_operations');
    }
}
