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


        return $query;
    }
}
