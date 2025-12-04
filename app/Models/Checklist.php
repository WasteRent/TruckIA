<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const PREVENTIVE = 7;
    public const CORRECTIVE = 8;

    public const TYPE_CONTAINER = 'container';
    public const TYPE_VEHICLE = 'vehicle';
    public const TYPE_REPAIR_ORDER = 'repair_order';

    public function fleet()
    {
        return $this->belongsTo(Fleet::class);
    }

    public function items()
    {
        return $this->hasMany(ChecklistItem::class);
    }

    public function repairOrderChecklists()
    {
        return $this->hasMany(RepairOrderChecklist::class);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeExcludingType($query, $type)
    {
        return $query->where(function($q) use ($type) {
            $q->where('type', '!=', $type)->orWhereNull('type');
        });
    }
}
