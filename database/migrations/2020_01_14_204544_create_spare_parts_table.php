<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spare_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fleet_id');
            $table->string('manufacturer')->nullable();
            $table->string('reference')->nullable();
            $table->string('short_reference')->nullable();
            $table->string('description');
            $table->decimal('unit_price', 8, 2)->nullable();
            $table->unsignedBigInteger('vehicle_manufacturer_id')->nullable();
            $table->unsignedBigInteger('vehicle_model_id')->nullable();
            $table->unsignedBigInteger('vehicle_maintenance_plan_id')->nullable();
            $table->unsignedBigInteger('vehicle_maintenance_plan_operation_id')->nullable();
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');

            $table->foreign('vehicle_manufacturer_id')->references('id')->on('manufacturers');
            $table->foreign('vehicle_model_id')->references('id')->on('models');
            $table->foreign('vehicle_maintenance_plan_id')->references('id')->on('maintenance_plans');
            $table->foreign('vehicle_maintenance_plan_operation_id')->references('id')->on('maintenance_plan_operations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spare_parts');
    }
}
