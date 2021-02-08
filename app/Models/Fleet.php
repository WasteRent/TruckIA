<?php

namespace App\Models;

use App\Models\Alert;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model
{
    protected $fillable = ['name', 'logo', 'notifications_email', 'crane_opening_hours', 'module_can_hours', 'module_tdf_hours', 'module_gps_chassis_hours', 'module_km', 'module_crane_work_hours', 'module_rc_gps_can', 'module_rc_chassis_box', 'module_rc_crane', 'module_source', 'module_OR', 'module_ITV', 'module_customers'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
