<?php

namespace App\Models;

use App\Models\Appointment;
use App\Models\File;
use App\Models\Garage;
use App\Models\RepairOrderOperation;
use App\Models\RepairOrderState;
use App\Models\Vehicle;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'fleet_id',
        'itv_correct',
        'scheduled_itv_date',
        'itv_file_id',
        'last_seen_at',
        'seen_at',
        'state_id',
        'remarks',
        'internal_notes',
        'authorized_at',
        'authorizer_user_id',
        'assigned_user_id',
        'finished_at',
        'garage_hourly_fare',
        'created_at',
        'kms',
        'work_hours_chassis',
        'work_hours_equipment'
    ];

    protected $casts = [
        'authorized_at' => 'datetime',
        'seen_at' => 'datetime',
        'last_seen_at' => 'datetime'
    ];

    public function scopeAuthorized($query)
    {
        return $query->whereNotNull('authorized_at');
    }

    public function scopeInProgress($query)
    {
        return $query->whereNull('finished_at');
    }

    public function scopePreventives($query)
    {
        return $query->where('type', 'preventive');
    }

    public function scopePreItvs($query)
    {
        return $query->where('type', 'pre-itv');
    }

    public function scopeCorrectives($query)
    {
        return $query->where('type', 'corrective');
    }

    public function isAuthorized()
    {
        return (bool) !empty($this->authorized_at);
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
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
        return $this->hasMany(RepairOrderOperation::class);
    }

    public function itvFile()
    {
        return $this->belongsTo(File::class, 'itv_file_id');
    }


    public function getCompletePercentAttribute()
    {
        $ops = $this->operations;
        return number_format(($ops->whereNotNull('completed_at')->count() / $ops->count()) * 100.00, 0);
    }

    public function isFinished()
    {
        return $this->state_id == RepairOrderState::CANCELED ||
                $this->state_id == RepairOrderState::FINISHED;
    }

    public function getAmount()
    {
        return $this->operations->sum(function ($operation) {
            return $operation->getAmount();
        });
    }

    public function updateSeenTimestamps()
    {
        if (!$this->seen_at) {
            $this->update(['seen_at' => new \DateTime]);
        }
        $this->update(['last_seen_at' => new \DateTime]);
    }

    public function formattedType()
    {
        if ($this->type == 'preventive') {
            return 'Preventivo';
        } elseif ($this->type == 'corrective') {
            return 'Correctivo';
        } elseif ($this->type == 'pre-itv') {
            return 'Pre-ITV';
        }
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

    public static function filter(array $filters)
    {
        $query = RepairOrder::query();

        if (isset($filters['id']) && $filters['id'] != null) {
            $query->where('id', $filters['id']);
        }
        if (isset($filters['type']) && $filters['type'] != null) {
            $query->where('type', $filters['type']);
        }
        if (isset($filters['state_id']) && $filters['state_id'] != null) {
            $query->where('state_id', $filters['state_id']);
        }

        return $query;
    }
}
