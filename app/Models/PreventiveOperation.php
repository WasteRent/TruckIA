<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventiveOperation extends Model
{
    protected $fillable = [
        'operation_family',
        'operation_subfamily',
        'operation_code',
        'operation_name',
        'operation_description',
    ];
}
