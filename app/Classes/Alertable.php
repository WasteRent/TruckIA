<?php

namespace App\Classes;

use App\Classes\AlertService;

trait Alertable
{
    public function sendAlert(int $vehicle_id, string $title, string $message, ?int $type_id = null)
    {
        (new AlertService)->notify($this->user->id, $vehicle_id, $title, $message, $type_id);
    }
}
