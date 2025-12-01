<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerChecklistItem extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'container_checklist_id',
        'checklist_item_id',
        'is_checked',
    ];

    protected $casts = [
        'is_checked' => 'boolean',
    ];

    public function containerChecklist()
    {
        return $this->belongsTo(ContainerChecklist::class);
    }

    public function checklistItem()
    {
        return $this->belongsTo(ChecklistItem::class);
    }
}
