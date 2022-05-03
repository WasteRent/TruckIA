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
            $table->unsignedBigInteger('assigned_customer_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('plate');
            $table->date('manufacturing_date')->nullable();
            $table->string('vin')->nullable();
            $table->string('fuel')->nullable();
            $table->boolean('tachograph')->nullable();
            $table->date('tachograph_date')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('discharged_date')->nullable();
            $table->date('last_itv_date')->nullable();
            $table->date('itv_date')->nullable();
            $table->date('extinguisher_date')->nullable();
            $table->boolean('itv_exempt')->default(false);
            $table->boolean('tachograph_exempt')->default(false);
            $table->date('warranty_date')->nullable();
            $table->date('renting_start_date')->nullable();
            $table->date('renting_end_date')->nullable();
            $table->unsignedDecimal('chassis_gps_work_hours', 10, 4)->default(0);
            $table->unsignedDecimal('chassis_can_work_hours', 10, 4)->default(0);
            $table->unsignedDecimal('equipment_work_hours', 10, 4)->default(0);
            $table->unsignedDecimal('work_ratio_chassis_equipment', 10, 4)->default(1);
            $table->unsignedDecimal('gps_can_ratio', 10, 4)->default(1);
            $table->enum('counters_source', ['gps', 'can'])->default('gps');
            $table->unsignedInteger('kms')->default(0);
            $table->unsignedInteger('cc3')->nullable();
            $table->unsignedInteger('power_kw')->nullable();
            $table->string('gearbox_type')->nullable();
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->unsignedBigInteger('chassis_maker_id');
            $table->unsignedBigInteger('chassis_model_id');
            $table->string('denomination')->nullable();
            $table->string('powertakeoff_type')->nullable();
            $table->string('powertakeoff_serial_number')->nullable();
            $table->string('powertakeoff_maker')->nullable();
            $table->string('powertakeoff_model')->nullable();
            $table->string('gearbox_serial_number')->nullable();
            $table->string('gearbox_maker')->nullable();
            $table->string('gearbox_model')->nullable();
            $table->unsignedInteger('number_of_axes')->nullable();
            $table->decimal('axe_1_2_distance')->nullable();
            $table->decimal('axe_2_3_distance')->nullable();
            $table->decimal('width')->nullable();
            $table->decimal('height')->nullable();
            $table->decimal('length')->nullable();
            $table->unsignedInteger('mma_kg')->nullable();
            $table->unsignedInteger('tare_kg')->nullable();
            $table->string('webfleet_id')->nullable();
            $table->string('euro')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['plate', 'fleet_id']);

            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('state_id')->references('id')->on('vehicle_states');
            $table->foreign('assigned_customer_id')->references('id')->on('customers');
            $table->foreign('chassis_maker_id')->references('id')->on('manufacturers');
            $table->foreign('chassis_model_id')->references('id')->on('models');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
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
