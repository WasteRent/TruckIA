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
        Schema::create('fleet_maintenance_operation_restrictions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_id');
            $table->unsignedBigInteger('plan_id');
            $table->unsignedBigInteger('operation_id');
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('users');
            $table->foreign('plan_id')->references('id')->on('maintenance_plans');
            $table->foreign('operation_id')->references('id')->on('maintenance_plan_operations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fleet_maintenance_operation_restrictions');
    }
};
