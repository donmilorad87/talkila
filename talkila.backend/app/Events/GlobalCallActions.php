<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GlobalCallActions implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action_on; //video or voice
    public $action; //mute or unmute
    public $room_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action_on, $action, $room_id)
    {
        $this->action_on = $action_on;
        $this->action = $action;
        $this->room_id = $room_id;
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
