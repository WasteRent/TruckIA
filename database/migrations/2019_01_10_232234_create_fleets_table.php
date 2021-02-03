<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFleetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fleets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('notifications_email')->nullable();
            $table->string('crane_opening_hours')->nullable();
            $table->string('module_can_hours')->default('Disabled');
            $table->string('module_tdf_hours')->default('Disabled');
            $table->string('module_gps_chassis_hours')->default('Disabled');
            $table->string('module_km')->default('Disabled');
            $table->string('module_crane_work_hours')->default('Disabled');
            $table->string('module_rc_gps_can')->default('Disabled');
            $table->string('module_rc_chassis_box')->default('Disabled');
            $table->string('module_rc_crane')->default('Disabled');
            $table->string('module_fuente')->default('Disabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fleets');
    }
}
