<?php

use AbinaChess\Game;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/game/{uid}', function(Request $request, $uid) {
    return Game::getGameOrFail($uid);
});

Route::post('/game/{uid}', ['as'=>'game.move', 'uses' => GameApi::class . '@move']);

Route::get('/shouts/{uid}', function(Request $request, $uid) {
    $game = Game::getGameOrFail($uid);
    return $game->shouts;
});
