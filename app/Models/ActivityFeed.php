<?php

namespace App\Models;

use App\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;

class ActivityFeed extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
