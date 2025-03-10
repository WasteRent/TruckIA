<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Fleet extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    public const ACCIONA = 11;

    protected $fillable = ['name', 'logo', 'notifications_email', 'crane_opening_hours', 'module_can_hours', 'module_tdf_hours', 'module_gps_chassis_hours', 'module_km', 'module_crane_work_hours', 'module_rc_gps_can', 'module_rc_chassis_box', 'module_rc_crane', 'module_source', 'module_OR', 'module_ITV', 'module_customers', 'vehicles_limit'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function repairOrders()
    {
        return $this->hasMany(RepairOrder::class);
    }

    public function garages()
    {
        return $this->hasMany(Garage::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function getRelatedFleets()
    {
        if (in_array($this->id, [1, 6])) {
            return Fleet::find([1, 6]);
        }

        return collect([$this]);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'entity_relation_id')->where('role', 'fleet');
    }

    public function customPlans()
    {
        return $this->belongsToMany(MaintenancePlan::class, 'fleet_maintenance_plans');
    }
}
