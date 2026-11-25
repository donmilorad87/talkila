<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event that gets broadcasted when call is extended for a single user
 */
class SingleUserExtension implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $end_time;
    public $identity;
    public $total_duration;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $total_duration, $end_time, $identity)
    {
        $this->message = $message;
        $this->total_duration = $total_duration;
        $this->end_time = $end_time;
        $this->identity = $identity;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("user.".$this->identity);
    }
}
