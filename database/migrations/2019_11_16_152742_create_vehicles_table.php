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
            $table->string('equipment_plate')->nullable();
            $table->date('registration_date')->nullable();
            $table->date('discharged_at')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->integer('kms')->nullable();
            $table->unsignedBigInteger('chassis_maker_id');
            $table->unsignedBigInteger('chassis_model_id');
            $table->unsignedBigInteger('equipment_maker_id')->nullable();
            $table->unsignedBigInteger('equipment_model_id')->nullable();
            $table->unsignedBigInteger('equipment2_maker_id')->nullable();
            $table->unsignedBigInteger('equipment2_model_id')->nullable();
            $table->unsignedBigInteger('equipment3_maker_id')->nullable();
            $table->unsignedBigInteger('equipment3_model_id')->nullable();
            $table->date('warranty_chassis')->nullable();
            $table->date('warranty_equipment1')->nullable();
            $table->date('warranty_equipment2')->nullable();
            $table->date('warranty_equipment3')->nullable();
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('chassis_maker_id')->references('id')->on('manufacturers');
            $table->foreign('chassis_model_id')->references('id')->on('models');
            $table->foreign('equipment_maker_id')->references('id')->on('manufacturers');
            $table->foreign('equipment_model_id')->references('id')->on('models');
            $table->foreign('equipment2_maker_id')->references('id')->on('manufacturers');
            $table->foreign('equipment2_model_id')->references('id')->on('models');
            $table->foreign('equipment3_maker_id')->references('id')->on('manufacturers');
            $table->foreign('equipment3_model_id')->references('id')->on('models');
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
