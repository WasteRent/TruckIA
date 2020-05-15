<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertType extends Model
{
    public const MAINTENANCE = 1;
    public const APPOINMENT = 2;
    public const ITV = 3;
    public const FAILURE = 4;
    public const ACCIDENT = 5;

    public const TYPES = [
        self::MAINTENANCE => 'Mantenimiento',
        self::APPOINMENT => 'Cita',
        self::ITV => 'ITV',
        self::FAILURE => 'Avería',
        self::ACCIDENT => 'Accidente'
    ];
}
