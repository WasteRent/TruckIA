<?php

namespace App\Events;

use App\Models\Vehicle;
use App\Models\VehicleState;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VehicleStateChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $vehicle;
    public $state;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Vehicle $vehicle, VehicleState $state)
    {
        $this->vehicle = $vehicle;
        $this->state = $state;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
