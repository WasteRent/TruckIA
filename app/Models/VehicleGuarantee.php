<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleGuarantee extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'guarantee',
        'user_id',
        'closed_at',
        'created_at',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function repair_orders()
    {
        return $this->hasMany(RepairOrder::class, 'related_guarantee_id');
    }

    public static function filter(array $filters)
    {
        $query = VehicleGuarantee::query();

        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->whereHas('vehicle', function ($q) use ($filters) {
                $q->where('plate', 'LIKE', "%{$filters['plate']}%");
            });
        }
        if (isset($filters['user_id']) && $filters['user_id'] != null) {
            $query->where('user_id', $filters['user_id']);
        }
        if (isset($filters['guarantee']) && $filters['guarantee'] != null) {
            $query->where('guarantee', 'LIKE', "%{$filters['guarantee']}%");
        }

        return $query;
    }
}
