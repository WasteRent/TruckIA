<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairOrder extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'remarks',
        'type',
        'vehicle_id',
        'garage_id',
        'creator_user_id',
        'authorizer_user_id',
        'state_id',
        'enterprise_type',
        'client',
        'description',
        'authorized_at',
        'observations',
        'operation_family',
        'operation_subfamily',
        'finished_at',
        'created_at',
        'sinister',
        'misuse',
        'kms',
        'work_hours_chassis',
        'work_hours_equipment',
        'left_the_workshop',
        'time_displacement',
        'workshop_date',
        'workshop_exit_date',
        'fleet_id',
        'assigned_user_id',
        'identificator',
        'file_id',
        'invoice_number',
        'spending_labor',
        'spending_materials',
        'internal_notes',
        'related_incident_id',
        'appointment'
    ];

    protected $casts = [
        'appointment' => 'date',
        'authorized_at' => 'datetime',
        'seen_at' => 'datetime',
        'last_seen_at' => 'datetime',
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
        return (bool) ! empty($this->authorized_at);
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

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
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

    public function parts()
    {
        return $this->hasMany(RepairOrderPart::class);
    }

    public function itvFile()
    {
        return $this->belongsTo(File::class, 'itv_file_id');
    }

    public function relatedIncident()
    {
        return $this->belongsTo(VehicleIncident::class, 'related_incident_id');
    }

    public function updateSeenTimestamps()
    {
        if (! $this->seen_at) {
            $this->update(['seen_at' => new \DateTime]);
        }
        $this->update(['last_seen_at' => new \DateTime]);
    }

    public function getCompletePercentAttribute()
    {
        $ops = $this->operations;

        return $ops->count() > 0
            ? number_format(($ops->whereNotNull('completed_at')->count() / $ops->count()) * 100.00, 0)
            : 0;
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

        if (isset($filters['plate']) && $filters['plate'] != null) {
            $query->whereHas('vehicle', function ($q) use ($filters) {
                $q->where('plate', 'like', '%'.$filters['plate'].'%');
            });
        }
        if (isset($filters['id']) && $filters['id'] != null) {
            $query->where('id', $filters['id']);
        }
        if (isset($filters['assigned_user_id']) && $filters['assigned_user_id'] != null) {
            $query->where('assigned_user_id', $filters['assigned_user_id']);
        }
        if (isset($filters['type']) && $filters['type'] != null) {
            $query->where('type', $filters['type']);
        }
        if (isset($filters['state_id']) && $filters['state_id'] != null) {
            $query->where('state_id', $filters['state_id']);
        }
        if (isset($filters['garage_id']) && $filters['garage_id'] != null) {
            $query->where('garage_id', $filters['garage_id']);
        }
        if (isset($filters['date_from']) && $filters['date_from'] != null) {
            $query->where('created_at', '>=', $filters['date_from'].' 00:00:00');
        }
        if (isset($filters['date_to']) && $filters['date_to'] != null) {
            $query->where('created_at', '<=', $filters['date_to'].' 23:59:59');
        }

        return $query;
    }
}
