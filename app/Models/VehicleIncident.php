<?php

namespace App\Models;

use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Model;

class VehicleIncident extends Model
{
    protected $fillable = ['incidence', 'user_id', 'created_at', 'closed_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
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
        
        return $query;
    }
}
