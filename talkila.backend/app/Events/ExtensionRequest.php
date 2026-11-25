<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
/**
 * Event that gets broadcasted when call extension is requested by the client
 */
class ExtensionRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $roomId;
    public $payment_amount;
    public $userIdentity;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $roomId, $payment_amount, $userIdentity)
    {
        $this->message = $message;
        $this->roomId = $roomId;
        $this->payment_amount = $payment_amount;
        $this->userIdentity = $userIdentity;
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
