<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleChecklistFiles extends Model
{
    use HasFactory;
    protected $fillable = [
        'technical_sheet',      
        'vehicle_registration', 
        'equipment_manual',     
        'vehicle_id',            
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
