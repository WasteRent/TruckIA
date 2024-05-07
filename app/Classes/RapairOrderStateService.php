<?php

namespace App\Classes;

use App\Events\MaintenanceUpdated;
use App\Events\RepairOrderStateChanged;
use App\Models\MaintenancePlan;
use App\Models\RepairOrder;
use App\Models\RepairOrderHistory;
use App\Models\RepairOrderState;
use Illuminate\Support\Facades\Auth;

class RapairOrderStateService
{
    public static function transit(int $repair_order_id, int $state_id)
    {
        $repair_order = RepairOrder::findOrFail($repair_order_id);

        if ($repair_order->state_id == $state_id) {
            return;
        }

        $repair_order->update(['state_id' => $state_id]);

        RepairOrderHistory::create([
            'repair_order_id' => $repair_order_id,
            'state_id' => $state_id,
            'user_id' => Auth::user()->id,
        ]);

        event(new RepairOrderStateChanged($repair_order, RepairOrderState::find($state_id)));

        if ($state_id == RepairOrderState::FINISHED) {
            $repair_order->update(['finished_at' => new \DateTime]);

            if ($repair_order->related_incident_id) {
                $repair_order->relatedIncident()->update(['closed_at' => now()]);
            }

            // Reset counters
            $used_plans = $repair_order->operations->pluck('maintenance_plan_id')->unique()->filter();
            $used_plans = MaintenancePlan::find($used_plans);

            $counters = collect([]);
            foreach ($used_plans as $plan) {
                $kms = $repair_order->vehicle->counters()->where([
                    ['type', 'kms'],
                    ['vehicle_category', $plan->vehicle_category],
                    ['max', $plan->kms],
                ])->get();

                $work_hours = $repair_order->vehicle->counters()->where([
                    ['type', 'work_hours'],
                    ['vehicle_category', $plan->vehicle_category],
                    ['max', $plan->can_hours],
                ])->get();

                $grua_hours = $repair_order->vehicle->counters()->where([
                    ['type', 'grua_hours'],
                    ['vehicle_category', $plan->vehicle_category],
                    ['max', $plan->grua_hours],
                ])->get();

                $natural_hours = $repair_order->vehicle->counters()->where([
                    ['type', 'natural_hours'],
                    ['vehicle_category', $plan->vehicle_category],
                    ['max', $plan->natural_hours],
                ])->get();

                $counters->push($kms->merge($work_hours)->merge($natural_hours));
            }

            foreach ($counters->flatten() as $counter) {
                $counter->reset();
            }

            event(new MaintenanceUpdated($repair_order->vehicle_id));
        }
    }
}
