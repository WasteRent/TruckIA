<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $guarded = [];
}
