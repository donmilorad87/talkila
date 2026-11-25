<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewRoomStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $user_id;
    public $socket_room_id;
    public $access_token;
    public $user_type;
    public $start_time;
    public $end_time;
    public $total_time;
    public $room_type;
    public $call_type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($participant, $room)
    {
        $this->user_id = $participant->user_id;
        $this->socket_room_id = $room->socket_room_id;
        $this->access_token = $participant->twilio_access_token;
        $this->user_type = $participant->user_type;
        $this->start_time = $room->talk_start_time;
        $this->end_time = $room->talk_end_time;
        $this->total_time = $room->duration;
        $this->room_type = $room->talk_type;
        $this->call_type = $room->call_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user.'.$this->user_id);
    }
}
