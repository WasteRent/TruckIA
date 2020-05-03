<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_user_id');
            $table->unsignedBigInteger('repair_order_id');
            $table->unsignedBigInteger('garage_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->dateTime('date_time');
            $table->text('notes')->nullable();
            $table->boolean('vehicle_received')->default(false);
            $table->timestamp('vehicle_received_at')->nullable();
            $table->timestamps();

            $table->foreign('garage_id')->references('id')->on('garages');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('repair_order_id')->references('id')->on('repair_orders');
            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
