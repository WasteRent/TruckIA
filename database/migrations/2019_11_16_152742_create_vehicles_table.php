<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fleet_id');
            $table->string('plate')->unique();
            $table->string('vin')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('itv_date')->nullable();
            $table->date('discharged_at')->nullable();
            $table->date('warranty_date')->nullable();
            $table->unsignedInteger('work_hours')->nullable();
            $table->unsignedInteger('can_hours')->nullable();
            $table->unsignedInteger('kms')->nullable();
            $table->unsignedInteger('cc3')->nullable();
            $table->unsignedInteger('power_kw')->nullable();
            $table->string('gearbox_type')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->unsignedBigInteger('chassis_maker_id');
            $table->unsignedBigInteger('chassis_model_id');
            $table->string('powertakeoff_serial_number')->nullable();
            $table->string('powertakeoff_maker')->nullable();
            $table->string('powertakeoff_model')->nullable();
            $table->string('gearbox_serial_number')->nullable();
            $table->string('gearbox_maker')->nullable();
            $table->string('gearbox_model')->nullable();
            $table->decimal('axes_distance')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('length')->nullable();
            $table->decimal('mma_kg')->nullable();
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('chassis_maker_id')->references('id')->on('manufacturers');
            $table->foreign('chassis_model_id')->references('id')->on('models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
