<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_id');
            $table->string('reference');
            $table->string('maker')->nullable();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('location')->nullable();
            $table->string('owner')->nullable();
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');
            $table->foreign('state_id')->references('id')->on('vehicle_states');
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
        Schema::dropIfExists('containers');
    }
};
