<?php

namespace App\Classes;

use App\Models\Alert;

class AlertService
{
    public function notify(int $user_id, int $vehicle_id, string $title, string $description, ?int $type_id = null)
    {
        Alert::create([
            'user_id'       => $user_id,
            'vehicle_id'    => $vehicle_id,
            'title'         => $title,
            'description'   => $description,
            'type_id'       => $type_id
        ]);
    }
}
