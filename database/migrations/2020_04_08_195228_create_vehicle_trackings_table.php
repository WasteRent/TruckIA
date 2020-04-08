<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_trackings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('object_uid')->unique();
            $table->unsignedBigInteger('kms');
            $table->unsignedBigInteger('engine_minutes')->nullable();
            $table->unsignedBigInteger('fuel_level_percent')->nullable();
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamp('fired_at');
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_trackings');
    }
}
