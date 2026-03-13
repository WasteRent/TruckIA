<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_tracking_debugs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provider');
            $table->string('service_key');
            $table->string('status')->default('pending'); // pending|success|error
            $table->longText('response')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_tracking_debugs');
    }
};

