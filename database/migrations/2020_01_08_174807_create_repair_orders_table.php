<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('garage_id')->nullable();
            $table->unsignedBigInteger('creator_user_id');
            $table->unsignedBigInteger('authorizer_user_id')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->text('remarks')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('garage_id')->references('id')->on('garages');
            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->foreign('authorizer_user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('repair_order_states');
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
