<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationSparePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation_spare_parts', function (Blueprint $table) {
            $table->unsignedBigInteger('operation_id');
            $table->unsignedBigInteger('spare_part_id');
            
            $table->foreign('operation_id')->references('id')->on('operations');
            $table->foreign('spare_part_id')->references('id')->on('spare_parts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation_spare_parts');
    }
}
