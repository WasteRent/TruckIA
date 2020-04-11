<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairOrderState extends Model
{
    public const PENDING_AUTHORIZATION = 1;
    public const AUTHORIZED = 2;
    public const REPAIRING = 3;
    public const FINISHED = 4;
    public const CANCELED = 5;
    public const VEHICLE_RECEIVED = 6;
    public const APPOINMENT_ARRANGED = 7;

    public const STATES = [
        self::PENDING_AUTHORIZATION => 'Pendiente de autorización',
        self::AUTHORIZED => 'Autorizada',
        self::REPAIRING => 'En reparación',
        self::FINISHED => 'Finalizada',
        self::CANCELED => 'Cancelada',
        self::VEHICLE_RECEIVED => 'Vehículo recepcionado',
        self::APPOINMENT_ARRANGED => 'Cita concertada',
    ];

    public const STATE_COLORS = [
        self::PENDING_AUTHORIZATION => 'bg-yellow-200 text-yellow-800',
        self::AUTHORIZED => 'bg-green-200 text-green-800',
        self::REPAIRING => 'bg-blue-200 text-blue-800',
        self::FINISHED => 'bg-gray-200 text-gray-800',
        self::CANCELED => 'bg-red-200 text-red-800',
        self::VEHICLE_RECEIVED => '',
        self::APPOINMENT_ARRANGED => ''
    ];
}
