<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleNote extends Model
{
    protected $fillable = ['note', 'user_id'];
}
