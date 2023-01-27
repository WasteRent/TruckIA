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
        Schema::create('vehicle_delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_user_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('type', ['delivery', 'return'])->nullable();
            $table->enum('fuel_level', ['empty', '1/4', '1/2', '3/4', 'full'])->nullable();
            $table->unsignedBigInteger('front_picture_id')->nullable();
            $table->unsignedBigInteger('back_picture_id')->nullable();
            $table->unsignedBigInteger('left_picture_id')->nullable();
            $table->unsignedBigInteger('right_picture_id')->nullable();
            $table->unsignedBigInteger('kms')->nullable();
            $table->unsignedBigInteger('hours')->nullable();
            $table->string('contract_type')->nullable();
            $table->text('comments')->nullable();
            $table->date('date')->nullable();

            $table->boolean('check_security')->nullable();
            $table->boolean('check_training')->nullable();
            $table->boolean('check_gps')->nullable();
            $table->boolean('check_front_tires')->nullable();
            $table->boolean('check_tires_2_axis')->nullable();
            $table->boolean('check_tires_3_axis')->nullable();
            $table->boolean('check_extinguisher')->nullable();
            $table->boolean('check_clean_cabin')->nullable();
            $table->boolean('check_clean_exterior')->nullable();

            $table->boolean('check_full_cycle')->nullable();
            $table->boolean('check_dump_cycle')->nullable();
            $table->boolean('check_lights')->nullable();
            $table->boolean('check_itv')->nullable();
            $table->boolean('check_tacograph')->nullable();
            $table->boolean('check_preventive_chassis')->nullable();
            $table->boolean('check_preventive_equipment')->nullable();
            $table->boolean('check_security_triangles')->nullable();
            $table->boolean('check_reflective_vest')->nullable();
            $table->boolean('check_documents')->nullable();
            $table->boolean('check_fluid_levels')->nullable();
            $table->boolean('check_rubber_status')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('front_picture_id')->references('id')->on('files');
            $table->foreign('back_picture_id')->references('id')->on('files');
            $table->foreign('left_picture_id')->references('id')->on('files');
            $table->foreign('right_picture_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_delivery_notes');
    }
};
