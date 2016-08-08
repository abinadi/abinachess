<?php

namespace AbinaChess\Http\Controllers;

use AbinaChess\Game;
use AbinaChess\Shout;
use Illuminate\Http\Request;

use AbinaChess\Http\Requests;

class GameController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Requests\GameRequest $request
     * @param Game $game
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\GameRequest $request, Game $game)
    {
        if ($request->color === 'random') {
            list($white, $black, $color) = $this->assignRandomColor($request);

            $game->white = $white;
            $game->black = $black;
        } elseif ($request->color === 'white') {
            $game->white = $request->name;
            $game->black = $request->opponent;
            $color = 'white';
        } else {
            $game->white = $request->opponent;
            $game->black = $request->name;
            $color = 'black';
        }

        $game->save();

        return redirect()->route('game.show', ['uid' => $game->uid, 'color' => $color]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $uid
     * @param string $color
     * @return \Illuminate\Http\Response
     */
    public function show($uid, $color = null)
    {
        if(is_null($color)) {
            return redirect()->route('game.join', ['uid' => $uid]);
        }

        $game = Game::getGameOrFail($uid);

        return view('chess')->with(compact('game', 'color'));
    }

	/**
	 * @param string $uid
	 *
	 * @return Response
	 */
	public function joinForm($uid)
	{
		$game = Game::getGameOrFail($uid);

		return view('join')->with(compact('game'));
	}

	/**
	 * @param string $uid
	 *
	 * @return Redirect
	 */
	public function join($uid)
	{
		return redirect()->route('game.show', ['uid' => $uid, 'color' => $request->input('color')]);
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param $request
     *
     * @return array
     */
    private function assignRandomColor($request)
    {
        $rand = mt_rand(1, 2);

        if ($rand == 1) {
            $white = $request->name;
            $black = $request->opponent;
            $color = 'white';
        } else {
            $white = $request->opponent;
            $black = $request->name;
            $color = 'black';
        }

        return [$white, $black, $color];
    }
}
