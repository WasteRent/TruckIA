<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleChecklistItem extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'vehicle_checklist_id',
        'checklist_item_id',
        'result',
    ];

    public function vehicleChecklist()
    {
        return $this->belongsTo(VehicleChecklist::class);
    }

    public function checklistItem()
    {
        return $this->belongsTo(ChecklistItem::class);
    }

}
