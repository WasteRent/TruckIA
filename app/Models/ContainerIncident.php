<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\User;

class ContainerIncident extends Model
{
    use HasFactory;

    protected $fillable = ['incidence', 'user_id', 'created_at', 'closed_at'];


    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public static function filter(array $filters)
    {
        $query = ContainerIncident::query();

        if (isset($filters['reference']) && $filters['reference'] != null) {
            $query->whereHas('container', function ($q) use ($filters) {
                $q->where('reference', 'LIKE', "%{$filters['reference']}%");
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
