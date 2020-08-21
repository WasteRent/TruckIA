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
            $table->enum('type', ['pre-itv', 'preventive', 'corrective']);
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('garage_id');
            $table->unsignedBigInteger('creator_user_id');
            $table->unsignedBigInteger('authorizer_user_id')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->unsignedDecimal('work_hours_chassis')->nullable();
            $table->unsignedDecimal('work_hours_equipment')->nullable();
            $table->unsignedInteger('kms')->nullable();
            $table->decimal('garage_hourly_fare')->default(0.00);
            $table->text('remarks')->nullable();
            $table->text('internal_notes')->nullable();
            $table->date('scheduled_itv_date')->nullable();
            $table->unsignedBigInteger('itv_file_id')->nullable();
            $table->boolean('itv_correct')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('seen_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamps();

            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('garage_id')->references('id')->on('garages');
            $table->foreign('creator_user_id')->references('id')->on('users');
            $table->foreign('authorizer_user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('repair_order_states');
            $table->foreign('itv_file_id')->references('id')->on('files');
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
