<?php

namespace AbinaChess\Events;

use AbinaChess\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MoveWasMade extends Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

	/**
	 * @var string
	 */
	public $uid;

	/**
	 * @var string
	 */
	public $pgn;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
		$this->uid = $game->uid;
		$this->pgn = $game->pgn;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [new Channel('abinachess_move.' . $this->uid)];
    }
}

