<?php

namespace App\Classes;

use App\Mail\AlertMail;
use App\Models\Alert;
use App\Models\Customer;
use App\Models\Fleet;
use App\Models\Garage;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Mail;

class AlertService
{
    private $entity;

    private $vehicle;

    public function to($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    public function forVehicle(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function notify(string $title, string $description, ?string $action_url = null, ?int $type_id = null)
    {
        // $email = $this->entity->notifications_email;
   
        if ($this->entity instanceof Fleet) {
            $relation = ['fleet_id' => $this->entity->id];
        } elseif ($this->entity instanceof Garage) {
            $relation = ['garage_id' => $this->entity->id];
        } elseif ($this->entity instanceof Customer) {
            $relation = ['customer_id' => $this->entity->id];
        }

        $data = array_merge($relation, [
            'vehicle_id' => $this->vehicle->id,
            'title' => $title,
            'description' => $description,
            'type_id' => $type_id,
            'action_url' => $action_url,
        ]);

        Alert::create($data);

        if ($this->entity instanceof Fleet) {
            $mail = new AlertMail($this->vehicle, $title, $description, $action_url);

            $this->entity->users->filter(function($user) {
                return $user->can_email_alerts;
            })->each(function($user) use ($mail) {
                Mail::to($user->email)->queue($mail);
            });
        }
    }
}
