<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ClientCallActions implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $action_on; //video or voice
    public $action; //mute or unmute
    public $identity;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action_on, $action, $identity)
    {
        $this->action_on = $action_on;
        $this->action = $action;
        $this->identity = $identity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user.'. $this->identity);
    }
}
