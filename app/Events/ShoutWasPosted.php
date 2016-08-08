<?php

namespace AbinaChess\Events;

use AbinaChess\Shout;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ShoutWasPosted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

	/**
	 * @var Shout
	 */
	public $shout;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Shout $shout)
    {
        $this->shout = $shout;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [new Channel('abinachess_shout.' . $this->shout->game_uid)];
    }
}

