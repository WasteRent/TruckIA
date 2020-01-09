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
}
