<?php

namespace App\Models;

use App\Models\Garage;
use App\Models\Operation;
use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Model;

class RepairOrder extends Model
{

    protected $casts = [
        'authorized_at' => 'datetime'
    ];

    public function scopeAuthorized($query)
    {
        return $query->whereNotNull('authorized_at');
    }

    public function isAuthorized()
    {
        return !empty($this->authorized_at);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    public function authorizer()
    {
        return $this->belongsTo(User::class, 'authorizer_user_id');
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function operations()
    {
        return $this->belongsToMany(Operation::class, 'repair_order_operations')
            ->withTimestamps()
            ->withPivot('real_time_in_hours', 'observations', 'file', 'completed', 'completed_at');
    }

    public function getCompletePercentAttribute()
    {
        $ops = $this->operations;
        return number_format(($ops->where('pivot.completed', 1)->count() / $ops->count()) * 100.00, 0);
    }

    public function isFinished()
    {
        return $this->operations()->wherePivot('completed', 0)->count() == 0;
    }

    public static function filters($builder)
    {
        $filters = [];

        if (isset($query['id']) && $query['id'] != null) {
            $filters[] = ['id', '=', $query['id']];
        }
        
        return $filters;
    }
}
