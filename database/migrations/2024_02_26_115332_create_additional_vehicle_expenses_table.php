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
        Schema::create('additional_vehicle_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_id');
            $table->date('date');
            $table->string('vehicle_reference');
            $table->text('description');
            $table->decimal('amount', 8, 2);
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_vehicle_expenses');
    }
};
