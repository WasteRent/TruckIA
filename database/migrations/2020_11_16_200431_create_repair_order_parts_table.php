<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrderPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_order_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_order_id');
            $table->unsignedBigInteger('repair_order_operation_id')->nullable();
            $table->string('manufacturer');
            $table->string('reference');
            $table->string('description');
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total_price', 8, 2);
            $table->timestamps();

            $table->foreign('repair_order_id')->references('id')->on('repair_orders');
            $table->foreign('repair_order_operation_id')->references('id')->on('repair_order_operations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_order_parts');
    }
}
