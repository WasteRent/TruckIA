<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AuditFilterService
{
    public const relatedTables = [
        'App\Models\RepairOrder'        => 'repair_orders',
        'App\Models\VehicleIncident'    => 'vehicle_incidents',
        'App\Models\Failure'            => 'failures',
        'App\Models\VehicleChecklist'   => 'vehicle_checklists',
        'App\Models\VehicleNote'        => 'vehicle_notes',
        'App\Models\Preventive'         => 'preventives',
        'App\Models\Appointment'        => 'appointments',
        'App\Models\VehicleDeliveryNote' => 'vehicle_delivery_notes',
        'App\Models\Alert'              => 'alerts',
    ];


    public function filterByInternalId(Builder $query, string $internalId): Builder
    {
        $vehicle = Vehicle::where('internal_id', $internalId)
            ->allowForUser()
            ->first("id");

        if ($vehicle) {
            $this->applyVehicleAndRelatedFilters($query, $vehicle->id);
        }

        return $query;
    }


    public function filterByPlate(Builder $query, string $plate): Builder
    {
        $vehicle = Vehicle::where('plate', 'LIKE', $plate)
            ->allowForUser()
            ->first("id");

        if ($vehicle) {
            $this->applyVehicleAndRelatedFilters($query, $vehicle->id);
        }

        return $query;
    }


    private function applyVehicleAndRelatedFilters(Builder $query, int $vehicleId): Builder
    {
        return $query->where(function ($q) use ($vehicleId) {
            $q->where('auditable_type', 'App\Models\Vehicle')
                ->where('auditable_id', $vehicleId);

            foreach (self::relatedTables as $model => $tableName) {
                $q = $this->filterByVehicleId($q, $vehicleId, $tableName, $model);
            }
        });
    }

    /**
     * Filtra por IDs de una tabla relacionada al vehículo
     */
    public function filterByVehicleId(Builder $query, int $vehicleId, ?string $tableName, string $model): Builder
    {

        $data = DB::table($tableName)
            ->where('vehicle_id', $vehicleId)
            ->pluck('id');

        if ($data->isNotEmpty()) {
            $query->orWhere(function ($subQuery) use ($data, $model) {
                $subQuery->where('auditable_type', $model)
                    ->whereIn('auditable_id', $data);
            });
        }

        return $query;
    }
}
