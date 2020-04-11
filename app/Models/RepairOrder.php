<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\Garage;
use App\Models\Operation;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Model;

class RepairOrder extends Model
{

    protected $fillable = ['last_seen_at', 'seen_at', 'state_id', 'remarks', 'authorized_at', 'authorizer_user_id'];

    protected $casts = [
        'authorized_at' => 'datetime',
        'seen_at' => 'datetime',
        'last_seen_at' => 'datetime'
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

    public function state()
    {
        return $this->belongsTo(RepairOrderState::class, 'state_id');
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }

    public function history()
    {
        return $this->hasMany(RepairOrderHistory::class)->latest();
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

    public function getInvoiceAmount()
    {
        return $this->operations->sum('pivot.real_time_in_hours') * $this->garage->hourly_price;
    }

    public function getEstimatedAmount()
    {
        return $this->operations->sum('time_in_hours') * $this->garage->hourly_price;
    }

    public function updateSeenTimestamps()
    {
        if (!$this->seen_at) {
            $this->update(['seen_at' => new \DateTime]);
        }
        $this->update(['last_seen_at' => new \DateTime]);
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['id']) && $query['id'] != null) {
            $filters[] = ['id', '=', $query['id']];
        }

        if (isset($query['type']) && $query['type'] != null) {
            $filters[] = ['type', '=', $query['type']];
        }

        if (isset($query['state_id']) && $query['state_id'] != null) {
            $filters[] = ['state_id', '=', $query['state_id']];
        }
        
        return $filters;
    }
}
