<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VehicleNote extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['note', 'user_id', 'vehicle_id', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
