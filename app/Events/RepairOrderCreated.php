<?php

namespace App\Events;

use App\Models\RepairOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RepairOrderCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $repairOrder;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RepairOrder $repairOrder)
    {
        $this->repairOrder = $repairOrder;
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
