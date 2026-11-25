<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event that gets broadcast when a call extension is requested by the client
 */
class ExtensionCancelled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $supplier_id;
    public $client_name;
    public $client_profile_picture;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $supplier_id, $client_name, $client_profile_picture)
    {
        $this->message                = $message;
        $this->supplier_id            = $supplier_id;
        $this->client_name            = $client_name;
        $this->client_profile_picture = $client_profile_picture;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("user." . $this->supplier_id);
    }
}
