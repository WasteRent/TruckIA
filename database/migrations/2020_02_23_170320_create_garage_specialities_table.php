<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGarageSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garage_specialities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('garage_id');
            $table->unsignedBigInteger('speciality_id');
            $table->decimal('stars', 2, 1)->nullable();
            $table->timestamps();

            $table->foreign('garage_id')->references('id')->on('garages');
            $table->foreign('speciality_id')->references('id')->on('specialities');

            $table->unique(['garage_id', 'speciality_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garage_specialities');
    }
}
