<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_files', function (Blueprint $table) {
            $table->unsignedBigInteger('delivery_id');
            $table->unsignedBigInteger('file_id');

            $table->foreign('delivery_id')->references('id')->on('vehicle_delivery_notes');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_files');
    }
}
