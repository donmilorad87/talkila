<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event that gets broadcasted when cron updates the duration it notifies the teacher with the updated time for all students
 */
class NotifyProvider implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $clients;
    public $roomId;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($clients, $roomId)
    {
        $this->clients = $clients;
        $this->roomId = $roomId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("room.".$this->roomId);
    }
}
