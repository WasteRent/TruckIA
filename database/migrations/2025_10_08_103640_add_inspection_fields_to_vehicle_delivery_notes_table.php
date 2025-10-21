<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicle_delivery_notes', function (Blueprint $table) {
            $table->string('check_front_tire_right')->nullable();
            $table->string('check_front_tire_left')->nullable();
            $table->string('check_tire_2_axis_right')->nullable();
            $table->string('check_tire_2_axis_left')->nullable();
            $table->string('check_tire_3_axis_right')->nullable();
            $table->string('check_tire_3_axis_left')->nullable();
            $table->string('check_front_axle_mud_flaps')->nullable();
            $table->string('check_axle_2_mud_flaps')->nullable();
            $table->string('check_axle_3_mud_flaps')->nullable();
            $table->string('check_fire_extinguishers')->nullable();
            $table->string('check_battery_cap')->nullable();
            $table->string('check_windows_glass')->nullable();
            $table->string('check_fuel_adblue_cap')->nullable();
            $table->string('check_rotating_work_lights')->nullable();
            $table->string('check_headlights_pilots_lamps')->nullable();
            $table->string('check_right_mirror')->nullable();
            $table->string('check_left_mirror')->nullable();
            $table->string('check_interior_cleaning')->nullable();
            $table->string('check_exterior_cleaning')->nullable();
            $table->string('check_vest_triangle_light')->nullable();
            $table->string('check_documentation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_delivery_notes', function (Blueprint $table) {
            $table->dropColumn([
                'check_front_tire_right',
                'check_front_tire_left',
                'check_tire_2_axis_right',
                'check_tire_2_axis_left',
                'check_tire_3_axis_right',
                'check_tire_3_axis_left',
                'check_front_axle_mud_flaps',
                'check_axle_2_mud_flaps',
                'check_axle_3_mud_flaps',
                'check_fire_extinguishers',
                'check_battery_cap',
                'check_windows_glass',
                'check_fuel_adblue_cap',
                'check_rotating_work_lights',
                'check_headlights_pilots_lamps',
                'check_right_mirror',
                'check_left_mirror',
                'check_interior_cleaning',
                'check_exterior_cleaning',
                'check_vest_triangle_light',
                'check_documentation'
            ]);
        });
    }
};
