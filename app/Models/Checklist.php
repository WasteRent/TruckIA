<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const PREVENTIVE = 7;
    public const CORRECTIVE = 8;

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
}
