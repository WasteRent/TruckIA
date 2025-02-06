<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleChecklistFileType extends Model
{
    use HasFactory;

    public function checklistFiles()
    {
        return $this->hasMany(VehicleChecklistFile::class, 'vehicle_checklist_file_type_id');
    }

}
