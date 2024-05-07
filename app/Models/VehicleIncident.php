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

    public function repair_order()
    {
        return $this->hasOne(RepairOrder::class, 'related_incident_id');
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

        return $query;
    }
}
