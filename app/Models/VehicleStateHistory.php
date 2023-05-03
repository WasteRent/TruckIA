<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VehicleStateHistory extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['state_id', 'user_id', 'vehicle_id', 'created_at'];

    public function state()
    {
        return $this->belongsTo(VehicleState::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
