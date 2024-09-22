<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VehicleIncident extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['incidence', 'user_id', 'created_at', 'closed_at', 'vehicle_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

    public function repair_orders()
    {
        return $this->hasMany(RepairOrder::class, 'related_incident_id');
    }

    public static function filter(array $filters)
    {
        $query = VehicleIncident::query();

        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->whereHas('vehicle', function ($q) use ($filters) {
                $q->where('plate', 'LIKE', "%{$filters['plate']}%");
            });
        }
        if (isset($filters['user_id']) && $filters['user_id'] != null) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['assigned_user_id']) && $filters['assigned_user_id'] != null) {
            $query->where('user_id', $filters['assigned_user_id']);
        }
        if (isset($filters['description']) && $filters['description'] != null) {
            $query->where('incidence', 'LIKE', "%{$filters['description']}%");
        }
        if (isset($filters['customer_id']) && $filters['customer_id'] != null) {
            $query->whereHas('vehicle', function ($q) use ($filters) {
                $q->where('assigned_customer_id', $filters['customer_id']);
            });
        }
        if (isset($filters['location_id']) && $filters['location_id'] != null) {
            $query->whereHas('vehicle', function ($q) use ($filters) {
                $q->where('location_id', $filters['location_id']);
            });
        }
        if (isset($filters['vehicle_type_id']) && $filters['vehicle_type_id'] != null) {
            $query->whereHas('vehicle', function ($q) use ($filters) {
                $q->where('vehicle_type_id', $filters['vehicle_type_id']);
            });
        }

        return $query;
    }
}
