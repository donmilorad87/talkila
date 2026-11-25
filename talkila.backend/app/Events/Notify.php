<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event that gets broadcasted when cron updates the duration
 */
class Notify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $roomId;
    public $total_duration;
    public $end_time;
    public $start_time;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $total_duration, $start_time, $end_time, $roomId)
    {
        $this->message = $message;
        $this->total_duration = $total_duration;
        $this->end_time = $end_time;
        $this->start_time = $start_time;
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
