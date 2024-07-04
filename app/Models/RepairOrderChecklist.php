<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairOrderChecklist extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['repair_order_id', 'checklist_id', 'notes', 'signature', 'grid', 'positions'];

    protected $casts = [
        'positions' => 'array',
    ];

    public function repairOrder()
    {
        return $this->belongsTo(RepairOrder::class);
    }

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function items()
    {
        return $this->hasMany(RepairOrderChecklistItem::class);
    }
}
