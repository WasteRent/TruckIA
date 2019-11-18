<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'plate',
        'registration_date',
        'kms',
        'chassis_maker',
        'chassis_model',
        'box_maker',
        'box_model'
    ];
}
