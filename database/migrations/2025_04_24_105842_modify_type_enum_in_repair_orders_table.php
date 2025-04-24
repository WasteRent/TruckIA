<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       DB::statement("ALTER TABLE repair_orders MODIFY type ENUM('pre-itv', 'preventive', 'corrective', 'weekly', 'tires', 'bad_use', 'support') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::statement("ALTER TABLE repair_orders MODIFY type ENUM('pre-itv', 'preventive', 'corrective', 'weekly', 'tires', 'bad_use') NOT NULL");
    }
};
