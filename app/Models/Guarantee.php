<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'description',
        'status',
        'creator_user_id',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function creator_user()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    public function repair_orders()
    {
        return $this->hasMany(RepairOrder::class, 'related_guarantee_id');
    }

    public static function filter(array $filters)
    {
        $query = Guarantee::query();

        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->whereHas('vehicle', function ($q) use ($filters) {
                $q->where('plate', 'LIKE', "%{$filters['plate']}%");
            });
        }
        if (isset($filters['creator_user_id']) && $filters['creator_user_id'] != null) {
            $query->where('creator_user_id', $filters['creator_user_id']);
        }
        if (isset($filters['description']) && $filters['description'] != null) {
            $query->where('description', 'LIKE', "%{$filters['description']}%");
        }

        return $query;
    }
}
