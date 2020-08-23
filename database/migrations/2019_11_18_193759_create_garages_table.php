<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGaragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('notifications_email')->nullable();
            $table->string('opening_hours')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('garage_email')->nullable();
            $table->string('garage_phone')->nullable();
            $table->string('garage_name')->nullable();
            $table->string('administration_email')->nullable();
            $table->string('administration_phone')->nullable();
            $table->string('administration_name')->nullable();
            $table->string('spare_parts_email')->nullable();
            $table->string('spare_parts_phone')->nullable();
            $table->string('spare_parts_name')->nullable();
            $table->string('management_email')->nullable();
            $table->string('management_phone')->nullable();
            $table->string('management_name')->nullable();
            $table->decimal('hourly_price')->nullable()->default(0.00);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('web')->nullable();
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('official_service1_manufacturer_id')->nullable();
            $table->unsignedBigInteger('official_service2_manufacturer_id')->nullable();
            $table->unsignedBigInteger('official_service3_manufacturer_id')->nullable();
            $table->unsignedBigInteger('official_service4_manufacturer_id')->nullable();
            $table->unsignedBigInteger('official_service5_manufacturer_id')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('official_service1_manufacturer_id')
                ->references('id')->on('manufacturers');
            $table->foreign('official_service2_manufacturer_id')
                ->references('id')->on('manufacturers');
            $table->foreign('official_service3_manufacturer_id')
                ->references('id')->on('manufacturers');
            $table->foreign('official_service4_manufacturer_id')
                ->references('id')->on('manufacturers');
            $table->foreign('official_service5_manufacturer_id')
                ->references('id')->on('manufacturers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garages');
    }
}
