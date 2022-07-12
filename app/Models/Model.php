<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    protected $fillable = ['name', 'category', 'technical_handbook_file_id', 'usage_handbook_file_id'];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class);
    }

    public function versions()
    {
        return $this->hasMany(Version::class);
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
