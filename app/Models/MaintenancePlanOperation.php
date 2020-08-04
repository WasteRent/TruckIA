<?php

namespace App\Models;

use App\Models\File;
use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class MaintenancePlanOperation extends EloquentModel
{
    protected $fillable = [
        'name', 'family_id', 'subfamily_id', 'time_in_hours', 'description', 'maintenance_plan_id'
    ];

    public function family()
    {
        return $this->belongsTo(OperationFamily::class);
    }

    public function subfamily()
    {
        return $this->belongsTo(OperationSubfamily::class);
    }

    public function attachment()
    {
        return $this->belongsTo(File::class, 'attachment_file_id');
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }
        
        return $filters;
    }
}
