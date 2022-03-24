<?php

namespace App\Models;

use App\Models\Alert;
use Illuminate\Database\Eloquent\Model;

class AlertType extends Model
{
    public const MAINTENANCE = 1;
    public const APPOINMENT = 2;
    public const ITV = 3;
    public const FAILURE = 4;
    public const ACCIDENT = 5;
    public const ESTINGUISHER = 6;
    public const WARRANTY = 7;
    public const TACHOGRAPH = 8;

    public const TYPES = [
        self::MAINTENANCE => 'Mantenimiento',
        self::APPOINMENT => 'Cita',
        self::ITV => 'ITV',
        self::FAILURE => 'Avería',
        self::ACCIDENT => 'Accidente',
        self::ESTINGUISHER => 'Extintor',
        self::WARRANTY => 'Garantía',
        self::TACHOGRAPH => 'Tacógrafo'
    ];

    public function pending() {
        return $this->hasMany(Alert::class, 'type_id')->where('dismissed', 0);
    }

}
