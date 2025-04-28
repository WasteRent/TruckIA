<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleWashingChecklist extends Model
{
    use HasFactory;

    public const ISCHECKED = '1';

    public const ISNOTCHECKED = '0';

    protected $fillable = ['vehicle_washing_id', 'vehicle_washing_type_id', 'is_checked'];

    public function vehicleWashingType()
    {
        return $this->belongsTo(VehicleWashingType::class);
    }
    
    
}
