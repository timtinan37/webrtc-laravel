<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel as PublicChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class Signalling implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PublicChannel('signalling-channel');
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    // public function broadcastWith()
    // {
    //     return [
    //         'localClientId' => $this->localClientId,
    //         'remoteClientId' => $this->remoteClientId
    //     ];
    // }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'message';
    }
}
