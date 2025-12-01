<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContainerChecklist extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['container_id', 'checklist_id', 'date'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function items()
    {
        return $this->hasMany(ContainerChecklistItem::class);
    }

    public static function filter(array $filters)
    {
        $query = ContainerChecklist::query();

        if (isset($filters['checklist_id']) && $filters['checklist_id'] != null) {
            $query->where('checklist_id', $filters['checklist_id']);
        }
        if (isset($filters['date']) && $filters['date'] != null) {
            $query->whereDate('date', $filters['date']);
        }

        return $query;
    }
}
