<?php

namespace App\Models;

use App\Models\OperationFamily;
use App\Models\OperationSubfamily;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        "code",
        "vehicle_type",
        "subfamily_id",
        "name",
        "time_in_hours",
        "description"
    ];


    public function subfamily()
    {
        return $this->belongsTo(OperationSubfamily::class);
    }

    public static function filters($query)
    {
        $filters = [];

        if (isset($query['code']) && $query['code'] != null) {
            $filters[] = ['code', '=', $query['code']];
        }
        if (isset($query['name']) && $query['name'] != null) {
            $filters[] = ['name', 'LIKE', '%'.$query['name'].'%'];
        }
        
        return $filters;
    }
}
