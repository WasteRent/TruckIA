<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id')->nullable();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('title');
            $table->text('description');
            $table->boolean('dismissed')->default(false);
            $table->string('action_url')->nullable();
            $table->unsignedBigInteger('fleet_id')->nullable();
            $table->unsignedBigInteger('garage_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('alert_types');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('garage_id')->references('id')->on('garages');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alerts');
    }
}
