<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertType extends Model
{
    public const MAINTENANCE = 1;

    public const TYPES = [
        self::MAINTENANCE => 'Mantenimiento'
    ];
}
