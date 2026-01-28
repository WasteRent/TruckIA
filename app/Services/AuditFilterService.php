<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class AuditFilterService
{

    private array $relatedModels = [
        'App\Models\RepairOrder',
        'App\Models\VehicleIncident',
        'App\Models\Failure',
        'App\Models\VehicleChecklist',
        'App\Models\VehicleNote',
        'App\Models\Preventive',
        'App\Models\Appointment',
        'App\Models\VehicleDeliveryNote',
        'App\Models\Alert',
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

            

            foreach ($this->relatedModels as $model) {
                $tableName = (new $model())->getTable();
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
