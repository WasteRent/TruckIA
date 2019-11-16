<?php

use App\Models\MaintenanceOperation;
use App\Models\MaintenanceOperationType;
use App\Models\MaintenancePlan;
use Illuminate\Database\Seeder;

class MaintenancePlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $op_engrase = MaintenanceOperationType::create(['name' => 'Engrase']);
        $op_revisar = MaintenanceOperationType::create(['name' => 'Revisar']);

        $planA = MaintenancePlan::create([
            'name' => 'Recolector Compactador CROSS RosRoca',
            'frequency' => '300 horas',
            'description' => 'Mantenimiento Preventivo'
        ]);

        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Rótulas cilindros conjunto prensa compactación',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Articulación carro pala',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Cojinete rueda / soporte patines deslizamiento',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Elevador contenedores, rodillos / corona dentada',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Elevador contenedores cremallera estabilizador',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Elevador contenedores articulación pisón cogida ventral',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Elevador contenedores gatillos seguridad brazos',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Transmisión bomba',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_revisar->id,
            'name' => 'Nivel lubricador',
            'acceptance' => 'Reponer a nivel máximo'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planA->id,
            'operation_type_id' => $op_revisar->id,
            'name' => 'Goma estanqueidad compuerta',
            'acceptance' => 'Estanqueidad, sin roturas'
        ]);

        //////////
        $planB = MaintenancePlan::create([
            'name' => 'Recolector Compactador CROSS RosRoca',
            'frequency' => '600 horas',
            'description' => 'Mantenimiento Preventivo'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Rótulas cilindros conjunto prensa compactación',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Articulación carro pala',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Cojinete rueda / soporte patines deslizamiento',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Elevador contenedores, rodillos / corona dentada',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Elevador contenedores cremallera estabilizador',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_engrase->id,
            'name' => 'Elevador contenedores articulación pisón cogida ventral',
            'acceptance' => 'Comprobación visual de salida de grasa'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_revisar->id,
            'name' => 'Ajuste gomas cierre eyectora',
            'acceptance' => 'Cota máxima 25 mm. en los extremos de la placa eyectora'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_revisar->id,
            'name' => 'Estriberas',
            'acceptance' => 'Apriete tornillos, funcionalidad y revisón visual soldaduras'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_revisar->id,
            'name' => 'Captares cilindros prensa compactación',
            'acceptance' => 'Apriete captadores y terminal, cambio de ciclo sin ruido'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_revisar->id,
            'name' => 'Puntales de seguridad',
            'acceptance' => 'Apriete tornillos, funcionalidad y revisón visual soldaduras'
        ]);
        MaintenanceOperation::create([
            'maintenance_plan_id' => $planB->id,
            'operation_type_id' => $op_revisar->id,
            'name' => 'Patines deslizamiento conjunto prensa compactación',
            'acceptance' => 'Patín lateral minimo 10 mm, patín frontal minimo 15 mm'
        ]);
    }
}
