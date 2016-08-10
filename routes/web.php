<?php

/**
 * Home - join a game or start a new game
 */
Route::get('/', function () {
    return view('home');
});

/**
 * pusher looks for this route... there is a way to do this, but until I find out how... there is this:
 */
Route::post('broadcasting/socket', function() {
    \Illuminate\Broadcasting\BroadcastController::class . '@rememberSocket';
});

/**
 * Process mini join form from the home page
 */
Route::post('join', function (Illuminate\Http\Request $request) {
	if(AbinaChess\Game::uidExists($request->input('uid'))) {
		return redirect()->route('game.join', ['uid' => $request->input('uid')]);
	}

	return redirect('/')->withErrors(['message' => 'That game does not exist.']);
});

/**
 * Start new game form - 3 part multi page form
 */
Route::get('start', function () {
    return view('start');
});

/**
 * Join Form - to join a game
 */
Route::get('game/{uid}/join', ['as' => 'game.join', 'uses' => GameController::class . '@joinForm']);
Route::post('game/{uid}/join', ['as' => 'game.joinredirect', 'uses' => GameController::class . '@join']);

/**
 * Process the start form
 */
Route::post('game', ['as' => 'game.store', 'uses' => GameController::class . '@store']);

/**
 * Display the chess board and start playing!
 */
Route::get('game/{uid}/{color?}', ['as' => 'game.show', 'uses' => GameController::class . '@show']);
