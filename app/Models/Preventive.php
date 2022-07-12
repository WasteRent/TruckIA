<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preventive extends Model
{
    protected $fillable = ['name', 'vehicle_id', 'customer_id', 'finished_at'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function operations()
    {
        return $this->hasMany(PreventiveOperation::class);
    }

    public function isFinished()
    {
        return ! empty($this->finished_at);
    }
}
