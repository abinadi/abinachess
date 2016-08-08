<?php

/**
 * Home - join a game or start a new game
 */
Route::get('/', function () {
    return view('home');
});

/**
 * Join Form - enter game uuid
 */
Route::get('join', function () {
    return view('home');
});

/**
 * Process Join Form
 */
Route::post('join', function () {
});

/**
 * Start new game form - 3 part multi page form
 */
Route::get('start', function () {
    return view('start');
});

/**
 * Process start form and
 */
Route::post('game', ['as' => 'game.store', 'uses' => GameController::class . '@store']);

Route::get('game/{uid}/{color?}', ['as' => 'game.show', 'uses' => GameController::class . '@show']);