<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('vehicle_checklist_file_types')
            ->where('name', 'Manual de equipo')
            ->update(['name' => 'Manual']);
    }

    public function down()
    {
        DB::table('vehicle_checklist_file_types')
            ->where('name', 'Manual')
            ->update(['name' => 'Manual de equipo']);
    }
};
