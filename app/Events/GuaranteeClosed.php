<?php

namespace App\Events;

use App\Models\VehicleGuarantee;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GuaranteeClosed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $guarantee;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(VehicleGuarantee $guarantee)
    {
        $this->guarantee = $guarantee;
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
