<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenancePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('manufacturer_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('name');
            $table->integer('power_kw')->nullable();
            $table->string('euro')->nullable();
            $table->unsignedBigInteger('kms')->nullable();
            $table->unsignedBigInteger('natural_hours')->nullable();
            $table->unsignedBigInteger('work_hours')->nullable();
            $table->unsignedBigInteger('can_hours')->nullable();
            $table->unsignedBigInteger('grua_hours')->nullable();
            $table->enum('vehicle_category', ['chassis', 'equipment'])->default('equipment');
            $table->enum('type', ['periodic', 'one-time'])->default('periodic');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
            $table->foreign('model_id')->references('id')->on('models');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('maintenance_plans');
    }
}
