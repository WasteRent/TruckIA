<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subfamily_id');
            $table->string('code');
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('time_in_hours', 3, 2)->default(0);
            $table->enum('vehicle_type', ['General', 'Barredora', 'Caja', 'Chasis', 'Otro'])->default('General');
            $table->timestamps();

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
        Schema::dropIfExists('operations');
    }
}
