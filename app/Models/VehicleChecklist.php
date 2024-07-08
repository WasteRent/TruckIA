<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleChecklist extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['vehicle_id', 'checklist_id', 'notes', 'signature', 'grid', 'positions'];

    protected $casts = [
        'positions' => 'array',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function items()
    {
        return $this->hasMany(VehicleChecklistItem::class);
    }
}
