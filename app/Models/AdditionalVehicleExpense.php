<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalVehicleExpense extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeAllowForUser($query){

        $query = $query->where(function($q) {
            $q->where('fleet_id', auth()->user()->fleet->id);
        });

        return $query;
    }

    public static function filter(array $filters)
    {
        $query = AdditionalVehicleExpense::query();

        if (isset($filters['date']) && $filters['date'] != null) {
            $query->where('date', $filters['date']);
        }
        if (isset($filters['vehicle_reference']) && $filters['vehicle_reference'] != null) {
            $query->where('vehicle_reference', 'like', '%'.$filters['vehicle_reference'].'%');
        }
        if (isset($filters['description']) && $filters['description'] != null) {
            $query->where('description', 'like', '%'.$filters['description'].'%');
        }
        if (isset($filters['customer_id']) && $filters['customer_id'] != null) {
            $query->where('customer_id', $filters['customer_id']);
        }
        if (isset($filters['date_from']) && $filters['date_from'] != null) {
            $query->where('date', '>=', $filters['date_from']);
        }
        if (isset($filters['date_to']) && $filters['date_to'] != null) {
            $query->where('date', '<=', $filters['date_to']);
        }
        if (isset($filters['active_customer']) && $filters['active_customer'] != null) {
            $query->where('customer_id', $filters['active_customer'])->where('vehicle_id', null);
        }

        return $query;
    }
}
