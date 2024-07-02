<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairOrderChecklistItem extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'repair_order_checklist_id',
        'checklist_item_id',
        'result',
    ];

    public function repairOrderChecklist()
    {
        return $this->belongsTo(RepairOrderChecklist::class);
    }

    public function checklistItem()
    {
        return $this->belongsTo(ChecklistItem::class);
    }

}
