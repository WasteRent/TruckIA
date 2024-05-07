<?php

namespace App\Listeners;

use App\Mail\OrderAssignedToMechanic;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyMechanicAssignedOrder implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->repairOrder->assigned_user_id) {
            Mail::to($event->repairOrder->assigned->email)->queue(new OrderAssignedToMechanic($event->repairOrder));
        }
    }
}
