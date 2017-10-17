<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Journal;

//"ShouldBroadcast" will instruct Laravel to broadcast the event when it is fired:
class Updated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Information about the Journal that was updated
     *
     * @var object
     */
    public $oJournal;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct( $oUpdatedJournal )
    {
        $this->oJournal = $oUpdatedJournal;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel( 'update.journal.' . $oJournal->id );
        return new PrivateChannel( 'update.journal' );
    }
}
