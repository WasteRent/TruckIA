<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VehicleNote extends Model
{
    protected $fillable = ['note', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
