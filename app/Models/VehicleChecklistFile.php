<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleChecklistFile extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_id','vehicle_checklist_file_type_id','is_checked'];

    public const ISCHECKED = '1';

    public const ISNOTCHECKED = '0';

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function fileType()
    {
        return $this->belongsTo(VehicleChecklistFileType::class, 'vehicle_checklist_file_type_id');
    }
    
}
