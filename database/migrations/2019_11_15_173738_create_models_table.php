<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('manufacturer_id');
            $table->string('name');
            $table->unsignedBigInteger('technical_handbook_file_id')->nullable();
            $table->unsignedBigInteger('usage_handbook_file_id')->nullable();
            $table->timestamps();

            $table->foreign('technical_handbook_file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('usage_handbook_file_id')->references('id')->on('files')->onDelete('cascade');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models');
    }
}
