<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'checklist_id',
        'category',
        'description',
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function repairOrderChecklistItems()
    {
        return $this->hasMany(RepairOrderChecklistItem::class);
    }
}
