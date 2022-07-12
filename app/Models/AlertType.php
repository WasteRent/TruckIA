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

    public const ESTINGUISHER = 6;

    public const WARRANTY = 7;

    public const TACHOGRAPH = 8;

    public const INCIDENT_CLOSED = 9;

    public const INCIDENT_OPENED = 10;

    public const ORDER_CREATED = 11;

    public const ORDER_STATE_CHANGED = 12;

    public const VEHICLE_CREATED = 13;

    public const VEHICLE_REASSIGNED = 14;

    public const VEHICLE_STATE_CHANGED = 15;

    public const TYPES = [
        self::MAINTENANCE => 'Mantenimiento',
        self::APPOINMENT => 'Cita',
        self::ITV => 'ITV',
        self::FAILURE => 'Avería',
        self::ACCIDENT => 'Accidente',
        self::ESTINGUISHER => 'Extintor',
        self::WARRANTY => 'Garantía',
        self::TACHOGRAPH => 'Tacógrafo',
        self::INCIDENT_CLOSED => 'Incidencia cerrada',
        self::INCIDENT_OPENED => 'Incidencia abierta',
        self::ORDER_CREATED => 'O.R. creada',
        self::ORDER_STATE_CHANGED => 'O.R. estados',
        self::VEHICLE_CREATED => 'Vehículo creado',
        self::VEHICLE_REASSIGNED => 'Vehículo reasignado',
        self::VEHICLE_STATE_CHANGED => 'Vehículo estados',
    ];

    public function pending()
    {
        return $this->hasMany(Alert::class, 'type_id')->where('dismissed', 0);
    }
}
