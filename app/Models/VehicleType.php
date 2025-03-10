<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class VehicleType extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public static function allowedTypes()
    {
        $fleet_id = auth()->user()->fleet->id;
        $blacklisted_types = DB::table('fleet_vehicle_type_blacklist')->where('fleet_id', $fleet_id)->pluck('vehicle_type_id');
        return self::whereNotIn('id', $blacklisted_types)->orderBy('name');
    }
}
