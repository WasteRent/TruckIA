<?php

namespace App\Jobs;

use App\Classes\AlertService;
use App\Models\AlertType;
use App\Models\MaintenancePlan;
use App\Models\Preventive;
use App\Models\PreventiveOperation;
use App\Models\Vehicle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class GenerateWeeklyCustomerPreventivesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $vehicles = Vehicle::active()->whereNotNull('assigned_customer_id')->get();

        DB::beginTransaction();

        try {
            foreach ($vehicles as $vehicle) {
                foreach ($vehicle->getMaintenancePlans() as $plan) {
                    if ($plan->isWeekly()) {
                        $preventive = $this->createPreventive($plan, $vehicle);
                        $this->notifyCustomer($plan, $preventive);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function createPreventive(MaintenancePlan $plan, Vehicle $vehicle)
    {
        $preventive = Preventive::create([
            'name' => 'Mantenimiento semanal',
            'vehicle_id' => $vehicle->id,
            'customer_id' => $vehicle->assigned_customer_id,
        ]);

        foreach ($plan->operations as $operation) {
            $preventive->operations()->save(new PreventiveOperation([
                'operation_family' => $operation->family->name,
                'operation_subfamily' => $operation->subfamily->name,
                'operation_name' => $operation->name,
                'operation_description' => $operation->description,
            ]));
        }

        return $preventive;
    }

    private function notifyCustomer(MaintenancePlan $plan, Preventive $preventive)
    {
        $action_url = "/customer/preventives/{$preventive->id}";
        (new AlertService)->to($preventive->customer)->forVehicle($preventive->vehicle)->notify(
            'Nuevo mantenimiento preventivo semanal',
            'El vehículo debe pasar el mantenimiento preventivo semanal',
            $action_url,
            AlertType::MAINTENANCE
        );
    }
}
