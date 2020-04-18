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
            $table->unsignedBigInteger('assigned_customer_id')->nullable();
            $table->string('plate')->unique();
            $table->string('vin')->nullable();
            $table->string('fuel')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('itv_date')->nullable();
            $table->date('discharged_at')->nullable();
            $table->date('warranty_date')->nullable();
            $table->unsignedDecimal('work_hours', 10, 4)->default(0);
            $table->unsignedDecimal('can_hours', 10, 4)->default(0);
            $table->unsignedInteger('kms')->default(0);
            $table->unsignedInteger('cc3')->nullable();
            $table->unsignedInteger('power_kw')->nullable();
            $table->string('gearbox_type')->nullable();
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->unsignedBigInteger('chassis_maker_id');
            $table->unsignedBigInteger('chassis_model_id');
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
            $table->timestamps();

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
