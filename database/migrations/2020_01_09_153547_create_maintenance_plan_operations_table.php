<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancePlanOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_plan_operations', function (Blueprint $table) {
            $table->unsignedBigInteger('maintenance_plan_id');
            $table->unsignedBigInteger('operation_id');

            $table->foreign('maintenance_plan_id')->references('id')->on('maintenance_plans');
            $table->foreign('operation_id')->references('id')->on('operations');
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
