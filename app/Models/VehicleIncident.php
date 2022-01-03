<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VehicleIncident extends Model
{
    protected $fillable = ['incidence', 'user_id', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
