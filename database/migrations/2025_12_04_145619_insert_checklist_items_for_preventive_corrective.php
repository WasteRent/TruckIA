<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('checklist_items')->insert([
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'EVALUACIÓN ESTRUCTURAL', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'VERIFICACIÓN POSICIONAMIENTO', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'COMPROBACIÓN TAPAS', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'REVISIÓN MECANISMO INTERNO', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'LIMPIEZA Y ESTADO HIGIÉNICO', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'ELIMINACIÓN DE GRAFITIS', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'APRIETE TORNILLERÍA', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'ENGRASE PARTES MÓVILES', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'INSPECCIÓN SEÑALÉTICA', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'VERIFICACIÓN TAG', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'COMPROBACIÓN SEGURIDAD VIAL', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'COMPROBACIÓN ACCESIBILIDAD', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 7, 'category' => 'ACTIVIDADES REALIZADAS', 'description' => 'INCIDENCIAS MENORES CORREGIDAS', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('checklist_items')->insert([
            ['checklist_id' => 8, 'category' => 'ACCIÓN REALIZADA', 'description' => 'REPARACIÓN IN SITU', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 8, 'category' => 'ACCIÓN REALIZADA', 'description' => 'TRASLADO A TALLER', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 8, 'category' => 'RESIDUOS GENERADOS', 'description' => 'LIXIVIADOS', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 8, 'category' => 'RESIDUOS GENERADOS', 'description' => 'RESIDUOS URBANOS', 'created_at' => now(), 'updated_at' => now()],
            ['checklist_id' => 8, 'category' => 'RESIDUOS GENERADOS', 'description' => 'OTROS', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('checklist_items')->whereIn('checklist_id', [7, 8])->delete();
    }
};
