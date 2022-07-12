<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Failure extends Model
{
    protected $fillable = [
        'reporter_user_id',
        'vehicle_id',
        'failure_type_id',
        'observations',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function type()
    {
        return $this->belongsTo(FailureType::class, 'failure_type_id');
    }
}
