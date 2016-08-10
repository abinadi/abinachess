<?php

namespace AbinaChess\Http\Controllers;

use AbinaChess\Events\MoveWasMade;
use AbinaChess\Game;
use AbinaChess\Http\Requests\MoveRequest;
use Ryanhs\Chess\Chess;

class GameApi extends Controller
{
    /**
     * @param MoveRequest $request
     * @param $uid
     * @param Chess $chess
     */
    public function move(MoveRequest $request, $uid, Chess $chess)
    {
        $move = $request->input('move');

        $game = Game::getGameOrFail($uid);

        $game->history = $this->createHistoryArray($move, $game->history);

        $game->pgn = $this->createPgn($chess, $game->history);

        $game->save();

        event(new MoveWasMade($game));
    }

    /**
     * @param $move
     * @param $history
     *
     * @return array
     */
    private function createHistoryArray($move, $history)
    {
        if(!is_array($history) || empty($history)) {
            $history = [];
        }

        $history[] = $move;

        return $history;
    }

    /**
     * @param Chess $chess
     * @param $history
     * @return string
     */
    private function createPgn(Chess $chess, $history)
    {
        foreach($history as $move) {
            $chess->move($move);
        }

        return $chess->pgn();
    }
}
