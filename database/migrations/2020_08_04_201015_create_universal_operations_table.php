<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniversalOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universal_operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('subfamily_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('time_in_hours')->default(0);
            $table->unsignedBigInteger('attachment_file_id')->nullable();
            $table->timestamps();

            $table->foreign('attachment_file_id')->references('id')->on('files');
            $table->foreign('family_id')->references('id')->on('operation_families');
            $table->foreign('subfamily_id')->references('id')->on('operation_subfamilies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('universal_operations');
    }
}
