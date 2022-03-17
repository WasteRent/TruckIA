<?php

namespace App\Events;

use App\Models\RepairOrder;
use App\Models\RepairOrderState;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RepairOrderStateChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $repairOrder;
    public $state;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RepairOrder $repairOrder, RepairOrderState $state)
    {
        $this->repairOrder = $repairOrder;
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
