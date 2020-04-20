<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrderHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_order_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_order_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('repair_order_id')->references('id')->on('repair_orders');
            $table->foreign('state_id')->references('id')->on('repair_order_states');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_order_histories');
    }
}
