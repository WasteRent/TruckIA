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
            $table->unsignedBigInteger('manufacturer_id');
            $table->unsignedBigInteger('model_id');
            $table->string('name');
            $table->string('frequency_type_1');
            $table->integer('frequency_1');
            $table->string('frequency_type_2')->nullable();
            $table->integer('frequency_2')->nullable();
            $table->string('frequency_type_3')->nullable();
            $table->integer('frequency_3')->nullable();
            $table->timestamps();

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
