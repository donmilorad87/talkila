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
class ClientRaiseHand implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $client_id;
    public $room_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($client_id, $room_id)
    {
        $this->client_id    = $client_id;
        $this->room_id      = $room_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("room.".$this->room_id);
    }
}
