<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairOrderState extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    public const PENDING_AUTHORIZATION = 1;

    public const AUTHORIZED = 2;

    public const REPAIRING = 3;

    public const FINISHED = 4;

    public const CANCELED = 5;

    public const APPOINMENT_ARRANGED = 6;

    public const VEHICLE_RECEIVED = 7;

    public const ITV_PAPER_SENT_TO_GARAGE = 8;

    public const ITV_PAPER_RECEIVED_BY_GARAGE = 9;

    public const ITV_PAPER_RETURNED_BY_GARAGE = 10;

    public const ITV_PAPER_RECEIVED_FROM_GARAGE = 11;

    public const FINISHED_PREITV = 12;

    public const ITV_APPOINTMENT_ARRANGED = 13;

    public const ITV_CORRECT = 14;

    public const ITV_FAILED = 15;

    public const PENDING_MANAGER_REVIEW = 16;

    public const STATES = [
        self::PENDING_MANAGER_REVIEW => 'Pendiente de revisar J.T.',
        self::PENDING_AUTHORIZATION => 'Pendiente de autorización',
        self::AUTHORIZED => 'Autorizada',
        self::REPAIRING => 'En reparación',
        self::FINISHED => 'Finalizada',
        self::CANCELED => 'Cancelada',
        self::VEHICLE_RECEIVED => 'Vehículo recepcionado',
        self::APPOINMENT_ARRANGED => 'Cita concertada',
        self::ITV_PAPER_SENT_TO_GARAGE => 'Documentación ITV enviada al taller',
        self::ITV_PAPER_RECEIVED_BY_GARAGE => 'Documentación ITV recibida por el taller',
        self::ITV_PAPER_RETURNED_BY_GARAGE => 'Documentación ITV devuelta por el taller',
        self::ITV_PAPER_RECEIVED_FROM_GARAGE => 'Documentación ITV recibida del taller',
        self::FINISHED_PREITV => 'Pre-ITV finalizada',
        self::ITV_APPOINTMENT_ARRANGED => 'Cita ITV concertada',
        self::ITV_CORRECT => 'ITV pasada',
        self::ITV_FAILED => 'ITV fallida',
    ];

    public const STATE_COLORS = [
        self::PENDING_MANAGER_REVIEW => 'bg-orange-200 text-orange-800',
        self::PENDING_AUTHORIZATION => 'bg-yellow-200 text-yellow-800',
        self::AUTHORIZED => 'bg-green-200 text-green-800',
        self::REPAIRING => 'bg-blue-200 text-blue-800',
        self::FINISHED => 'bg-gray-200 text-gray-800',
        self::CANCELED => 'bg-red-200 text-red-800',
        self::VEHICLE_RECEIVED => '',
        self::APPOINMENT_ARRANGED => '',
        self::ITV_PAPER_SENT_TO_GARAGE => '',
        self::ITV_PAPER_RECEIVED_BY_GARAGE => '',
        self::ITV_PAPER_RECEIVED_FROM_GARAGE => '',
        self::ITV_PAPER_RETURNED_BY_GARAGE => '',
        self::FINISHED_PREITV => '',
        self::ITV_APPOINTMENT_ARRANGED => '',
        self::ITV_CORRECT => '',
        self::ITV_FAILED => '',
    ];
}
