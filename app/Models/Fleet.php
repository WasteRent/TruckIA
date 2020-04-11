<?php

namespace App\Models;

use App\Classes\AlertService;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $fillable = ['name', 'logo'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
