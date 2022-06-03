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
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('type', ['delivery', 'return'])->nullable();
            $table->enum('fuel_level', ['empty', '1/4', '1/2', '3/4', 'full'])->nullable();
            $table->unsignedBigInteger('front_picture_id')->nullable();
            $table->unsignedBigInteger('back_picture_id')->nullable();
            $table->unsignedBigInteger('left_picture_id')->nullable();
            $table->unsignedBigInteger('right_picture_id')->nullable();
            $table->text('comments')->nullable();
            $table->date('date')->nullable();
            $table->boolean('check_front_tires')->nullable();
            $table->boolean('check_tires_2_axis')->nullable();
            $table->boolean('check_tires_3_axis')->nullable();
            $table->boolean('check_extinguisher')->nullable();
            $table->boolean('check_clean_cabin')->nullable();
            $table->boolean('check_clean_exterior')->nullable();

            $table->timestamps();

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
