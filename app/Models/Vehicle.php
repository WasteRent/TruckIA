<?php

namespace App\Models;

use App\Operation;
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

    protected $casts = [
        'registration_date' => 'date'
    ];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }

    public function getChassisAttribute()
    {
        return "{$this->chassis_maker} {$this->chassis_model}";
    }

    public function getBoxAttribute()
    {
        return "{$this->box_maker} {$this->box_model}";
    }
}
