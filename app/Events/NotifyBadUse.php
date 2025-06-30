<?php

namespace App\Events;

use App\Models\Garage;
use App\Mail\NotifyBadUseMail;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyBadUse implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public function handle($event)
    {
        Mail::to('crisadame@wasterent.es')->queue(new NotifyBadUseMail($event->repairOrder));
    }

    public function shouldQueue($event)
    {
        return $event->repairOrder->type == 'bad_use' && ($event->repairOrder->garage_id == Garage::WASTERENT_SEVILLA || $event->repairOrder->garage_id == Garage::WASTERENT_HUELVA);
    }
}