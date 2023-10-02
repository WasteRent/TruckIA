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
        Schema::create('container_pictures', function (Blueprint $table) {
            $table->unsignedBigInteger('container_id');
            $table->unsignedBigInteger('file_id');
            $table->unsignedInteger('cover')->default(0);

            $table->foreign('container_id')->references('id')->on('containers');
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
        Schema::dropIfExists('container_pictures');
    }
};
