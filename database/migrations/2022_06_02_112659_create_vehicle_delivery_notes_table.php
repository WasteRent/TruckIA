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
            $table->text('signature')->nullable();

            $table->string('check_security')->nullable();
            $table->string('check_training')->nullable();
            $table->string('check_gps')->nullable();
            $table->string('check_front_tires')->nullable();
            $table->string('check_tires_2_axis')->nullable();
            $table->string('check_tires_3_axis')->nullable();
            $table->string('check_extinguisher')->nullable();
            $table->string('check_clean_cabin')->nullable();
            $table->string('check_clean_exterior')->nullable();

            $table->string('check_full_cycle')->nullable();
            $table->string('check_dump_cycle')->nullable();
            $table->string('check_lights')->nullable();
            $table->string('check_itv')->nullable();
            $table->string('check_tacograph')->nullable();
            $table->string('check_preventive_chassis')->nullable();
            $table->string('check_preventive_equipment')->nullable();
            $table->string('check_security_triangles')->nullable();
            $table->string('check_reflective_vest')->nullable();
            $table->string('check_documents')->nullable();
            $table->string('check_fluid_levels')->nullable();
            $table->string('check_rubber_status')->nullable();

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
