<?php

namespace AbinaChess\Http\Controllers;

use AbinaChess\Game;
use AbinaChess\Shout;
use Illuminate\Http\Request;

use AbinaChess\Http\Requests;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

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
            list($white, $black) = $this->assignRandomColor($request);

            $game->white = $white;
            $game->black = $black;
        } elseif ($request->color === 'white') {
            $game->white = $request->name;
            $game->black = $request->opponent;
        } else {
            $game->white = $request->opponent;
            $game->black = $request->name;
        }

        $game->save();

        return redirect()->route('game.show', ['uid' => $game->uid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $uid
     * @return \Illuminate\Http\Response
     */
    public function show($uid)
    {
        $game = Game::getGameOrFail($uid);

        // 2. Display the play area (chess board) with the game uid
        return view('chess')->with(compact('game'));
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
        } else {
            $white = $request->opponent;
            $black = $request->name;
        }

        return [$white, $black];
    }
}
