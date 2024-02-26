<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalVehicleExpense extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function filter(array $filters)
    {
        $query = AdditionalVehicleExpense::query();

        if (isset($filters['date']) && $filters['date'] != null) {
            $query->where('date', $filters['date']);
        }
        if (isset($filters['vehicle_reference']) && $filters['vehicle_reference'] != null) {
            $query->where('vehicle_reference', 'like', "%" . $filters['vehicle_reference'] . "%");
        }
        if (isset($filters['description']) && $filters['description'] != null) {
            $query->where('description', 'like', "%" . $filters['description'] . "%");
        }

        return $query;
    }
}
