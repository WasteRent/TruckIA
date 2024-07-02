<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('checklists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fleet_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('fleet_id')->references('id')->on('fleets');
        });
    }

    public function down()
    {
        Schema::dropIfExists('checklists');
    }
};
