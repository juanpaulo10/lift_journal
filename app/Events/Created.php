<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

//"ShouldBroadcast" will instruct Laravel to broadcast the event when it is fired:
class Created implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $body;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->body = "Example";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('createdjournal');
    }
}
