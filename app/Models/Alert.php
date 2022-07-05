<?php

namespace App\Models;

use App\Models\AlertType;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    protected $fillable = [
        'fleet_id',
        'garage_id',
        'customer_id',
        'vehicle_id',
        'action_url',
        'title',
        'description',
        'type_id',
        'dismissed'
    ];

    public function scopePending($query)
    {
        return $query->where('dismissed', 0);
    }


    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class)->withTrashed();
    }

    public function type()
    {
        return $this->belongsTo(AlertType::class);
    }

    public static function filter(array $filters)
    {
        $query = Alert::query();

        if (isset($filters['filter']) && $filters['filter'] != null) {
            if ($filters['filter'] == 'today') {
                $query->where('created_at', '>', date('Y-m-d H:i:s', strtotime('-24 hours')));
            }
        }
        if (isset($filters['type_id']) && $filters['type_id'] != null) {
            $query->where('type_id', "{$filters['type_id']}");
        }
        if (isset($filters['dismissed']) && $filters['dismissed'] != null) {
            $query->where('dismissed', "{$filters['dismissed']}");
        }
        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->whereHas('vehicle', function ($query) use ($filters) {
                $query->where('plate', 'LIKE', "%{$filters['plate']}%");
            });
        }

        return $query;
    }
}
