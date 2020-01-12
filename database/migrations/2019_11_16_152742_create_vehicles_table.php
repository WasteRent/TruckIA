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
            $table->date('registration_date')->nullable();
            $table->integer('kms')->nullable();
            $table->unsignedBigInteger('chassis_maker_id');
            $table->unsignedBigInteger('chassis_model_id');
            $table->unsignedBigInteger('box_maker_id')->nullable();
            $table->unsignedBigInteger('box_model_id')->nullable();
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('chassis_maker_id')->references('id')->on('manufacturers');
            $table->foreign('chassis_model_id')->references('id')->on('models');
            $table->foreign('box_maker_id')->references('id')->on('manufacturers');
            $table->foreign('box_model_id')->references('id')->on('models');
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
