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
            $table->id();
            $table->unsignedBigInteger('repair_order_id');
            $table->string('operation_family')->nullable();
            $table->string('operation_subfamily')->nullable();
            $table->string('operation_code')->nullable();
            $table->string('operation_name');
            $table->unsignedBigInteger('operation_attachment_file_id')->nullable();
            $table->text('operation_description')->nullable();
            $table->text('garage_observations')->nullable();
            $table->unsignedBigInteger('file_id')->nullable();
            $table->decimal('estimated_time_in_hours')->nullable();
            $table->decimal('real_time_in_hours')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('repair_order_id')->references('id')->on('repair_orders');
            $table->foreign('operation_attachment_file_id')->references('id')->on('files');
            $table->foreign('file_id')->references('id')->on('files');
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
        Schema::dropIfExists('operations');
    }
}
