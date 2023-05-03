<?php

namespace App\Models;

use App\Models\FleetMaintenanceOperationRestriction;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class MaintenancePlanOperation extends EloquentModel implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name', 'family_id', 'subfamily_id', 'time_in_hours', 'description', 'maintenance_plan_id',
    ];

    public function family()
    {
        return $this->belongsTo(OperationFamily::class);
    }

    public function subfamily()
    {
        return $this->belongsTo(OperationSubfamily::class);
    }

    public function plan()
    {
        return $this->belongsTo(MaintenancePlan::class, 'maintenance_plan_id');
    }

    public function parts()
    {
        return $this->hasMany(SparePart::class, 'vehicle_maintenance_plan_operation_id');
    }

    public function attachment()
    {
        return $this->belongsTo(File::class, 'attachment_file_id');
    }

    public function isRestricted() {
        return FleetMaintenanceOperationRestriction::where([
            'operation_id' => $this->id,
            'fleet_id' => auth()->user()->fleet->id
        ])->exists();
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }

        return $filters;
    }
}
