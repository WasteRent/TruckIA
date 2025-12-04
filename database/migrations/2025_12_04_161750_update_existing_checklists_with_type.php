<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Checklist;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('checklists')
            ->whereIn('id', [Checklist::PREVENTIVE, Checklist::CORRECTIVE])
            ->update(['type' => Checklist::TYPE_CONTAINER]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('checklists')
            ->whereIn('id', [Checklist::PREVENTIVE, Checklist::CORRECTIVE])
            ->update(['type' => null]);
    }
};
