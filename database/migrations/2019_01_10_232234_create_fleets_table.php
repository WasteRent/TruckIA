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
            $table->integer('vehicles_limit')->nullable();
            $table->string('notifications_email')->nullable();
            $table->string('crane_opening_hours')->nullable();
            $table->boolean('module_can_hours')->default(false);
            $table->boolean('module_tdf_hours')->default(false);
            $table->boolean('module_gps_chassis_hours')->default(false);
            $table->boolean('module_km')->default(false);
            $table->boolean('module_crane_work_hours')->default(false);
            $table->boolean('module_rc_gps_can')->default(false);
            $table->boolean('module_rc_chassis_box')->default(false);
            $table->boolean('module_rc_crane')->default(false);
            $table->boolean('module_source')->default(false);
            $table->boolean('module_OR')->default(false);
            $table->boolean('module_ITV')->default(false);
            $table->boolean('module_customers')->default(false);
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
