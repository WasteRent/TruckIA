<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('maintenance_plan_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('garage_id');
            $table->boolean('completed')->default(false);
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->foreign('maintenance_plan_id')->references('id')->on('maintenance_plans');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('garage_id')->references('id')->on('garages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
