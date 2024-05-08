<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchVehicleJsonController extends Controller
{
    public function index(Request $request)
    {
        $user = User::find(1031);
        $vehicles = Vehicle::filter($request->all())->whereHas('tracking')->where('fleet_id', $user->fleet->id)->get();

        if ($vehicles->isEmpty()) {
            return response()->json([], 404);
        }

        $data = $vehicles->map(function ($vehicle) {
            $equipment = $vehicle->equipments->first();
            return [
                "id" => $vehicle->id,
                "internal_id" => $vehicle->internal_id,
                "fleet_id" =>  $vehicle->fleet->id,
                "fleet" =>  $vehicle->fleet->name,
                "description" => "{$vehicle?->chassis} {$equipment?->type} {$equipment?->maker?->name} {$equipment?->model?->name}",
                "contract_id" => $vehicle->customer->id,
                "contract" => $vehicle->customer->name,
                "plate" => $vehicle->plate,
                "vin" => $vehicle->vin,
                "maker_id" => $vehicle->chassis_maker_id,
                "maker" => $vehicle->chassisMaker?->name,
                "model_id" => $vehicle->chassis_model_id,
                "model" => $vehicle->chassisModel?->name,
                "vehicle_type_id" => $vehicle->vehicle_type_id,
                "vehicle_type" => $vehicle->type?->name,
                "fuel" => $vehicle->fuel,
                "euro" => $vehicle->euro,
                "state_id" => $vehicle->state_id,
                "state" => $vehicle->state?->name,
                "kms" => $vehicle->kms,
                "chassis_can_hours" => $vehicle->chassis_can_work_hours,
                "itv_date" =>  $vehicle->itv_date,
                "itv_expired" => $vehicle->itv_date < date('Y-m-d'),
                "tachograph_exempt" => $vehicle->tachograph_exempt,
                "tachograph" =>  $vehicle->tachograph,
                "tachograph_date" => $vehicle->tachograph_date,
                "maintenances" =>  $vehicle->counters->where('vehicle_category', 'chassis')->sortByDesc('completedPercent')->map(function ($counter) {
                    return [
                        "id" => $counter->id,
                        "name" => $counter->description,
                        "current_value" => $counter->current,
                        "max_value" => $counter->max,
                        "unit" => $counter->plan?->name
                    ];
                })->toArray(),
                "equipments" =>  $vehicle->equipments->map(function ($equipment) use ($vehicle) {
                    return [
                        "id" => $equipment->id,
                        "maker_id" => $equipment->maker?->id,
                        "maker" => $equipment->maker?->name,
                        "model_id" => $equipment->model?->id,
                        "model" => $equipment->model?->name,
                        "type" => $equipment->type,
                        "maintenances" =>  $vehicle->counters->where('vehicle_category', 'equipment')->map(function ($counter) {
                            return [
                                "id" => $counter->id,
                                "name" => $counter->description,
                                "current_value" => $counter->current,
                                "max_value" => $counter->max,
                                "unit" => $counter->plan->name
                            ];
                        })->toArray(),
                    ];
                })->toArray(),
            ];
        })->toArray();


        return response()->json(['data' => $data], 200);
    }
}
