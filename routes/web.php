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
Route::get('join', function() {});

/**
 * Process Join Form
 */
Route::post('join', function() {});

/**
 * Start new game form - 3 part multi page form
 */
Route::get('start', function() {
    return view('start');
});

/**
 * Process start form and
 */
Route::post('game', function() {
    // 1. Create a new game from input fields
    // 2. Display the play area (chess board) with the game uid
    // 2.a. From here, the js app takes over
});