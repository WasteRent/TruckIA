<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnterpriseGroup extends Model
{
    protected $fillable = ['name', 'email', 'contact', 'phone', 'address'];
}
