<?php

namespace App\Models;

use App\Models\Alert;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $fillable = ['name', 'logo', 'notifications_email'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
