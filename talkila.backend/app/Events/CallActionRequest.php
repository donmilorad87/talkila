<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CallActionRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action_state; // on or off
    public $action;       //voice or video
    public $user_id;
    public $room_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action, $action_state, $user_id, $room_id)
    {
        $this->action_state = $action_state;
        $this->action       = $action;
        $this->user_id      = $user_id;
        $this->room_id      = $room_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel("room.{$this->room_id}");
    }
}
