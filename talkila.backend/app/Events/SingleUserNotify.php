<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event that gets broadcasted when duration is calculated for single user after extension - deals with multiple extensions
 */
class SingleUserNotify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $identity;
    public $total_duration;
    public $end_time;
    public $start_time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $total_duration, $start_time, $end_time, $identity)
    {
        $this->message = $message;
        $this->total_duration = $total_duration;
        $this->end_time = $end_time;
        $this->start_time = $start_time;
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
