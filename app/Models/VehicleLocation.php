<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleLocation extends Model
{
    use HasFactory;

    protected $guarded = [];


    public static function filter(array $filters)
    {
        $query = VehicleLocation::query();

        if (isset($filters['name']) && $filters['name'] != null) {
            $query->where('name', 'LIKE', "%{$filters['name']}%");
        }

        return $query;
    }
}
