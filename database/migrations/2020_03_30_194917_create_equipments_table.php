<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->string('plate')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('maker_id');
            $table->unsignedBigInteger('model_id');
            $table->string('version')->nullable();
            $table->date('warranty_date')->nullable();
            $table->string('bomb_serial_number')->nullable();
            $table->string('bomb_maker')->nullable();
            $table->string('bomb_model')->nullable();
            $table->unsignedBigInteger('picture_file_id')->nullable();
            $table->timestamps();

            $table->foreign('picture_file_id')->references('id')->on('files')->onDelete('set null');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('maker_id')->references('id')->on('manufacturers');
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
        Schema::dropIfExists('equipments');
    }
}
