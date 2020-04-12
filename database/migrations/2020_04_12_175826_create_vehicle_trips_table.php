<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('trip_uid')->unique();
            $table->unsignedBigInteger('duration_minutes');
            $table->unsignedBigInteger('distance_kms');
            $table->string('start_address');
            $table->string('end_address');
            $table->string('start_latitude');
            $table->string('start_longitude');
            $table->string('end_latitude');
            $table->string('end_longitude');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
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
        Schema::dropIfExists('vehicle_trips');
    }
}
