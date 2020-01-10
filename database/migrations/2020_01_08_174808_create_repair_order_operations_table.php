<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrderOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_order_operations', function (Blueprint $table) {
            $table->unsignedBigInteger('repair_order_id');
            $table->unsignedBigInteger('operation_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('repair_order_id')->references('id')->on('repair_orders');
            $table->foreign('operation_id')->references('id')->on('operations');
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
