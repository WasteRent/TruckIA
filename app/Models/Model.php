<?php

namespace App\Models;

use App\Models\File;
use App\Models\MaintenancePlan;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $fillable = ['name', 'technical_handbook_file_id', 'usage_handbook_file_id'];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function technicalHandbook()
    {
        return $this->belongsTo(File::class, 'technical_handbook_file_id');
    }

    public function usageHandbook()
    {
        return $this->belongsTo(File::class, 'usage_handbook_file_id');
    }

    public function plans()
    {
        return $this->hasMany(MaintenancePlan::class);
    }
}
