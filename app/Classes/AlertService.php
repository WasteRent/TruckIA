<?php

namespace App\Classes;

use App\Models\Alert;
use Ramsey\Uuid\Uuid;

class AlertService
{
    public function notify(int $user_id, int $vehicle_id, string $title, string $description)
    {
        $alert = Alert::create([
            'uuid'          => Uuid::uuid4(),
            'user_id'       => $user_id,
            'vehicle_id'    => $vehicle_id,
            'title'         => $title,
            'description'   => $description
        ]);
    }
}
