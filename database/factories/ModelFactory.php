<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(AbinaChess\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(AbinaChess\Game::class, function (Faker\Generator $faker) {
    return [
        'black' => $faker->name,
        'white' => $faker->name,
        'history' => $faker->text(20)
    ];
});

$factory->define(AbinaChess\Shout::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'shout' => $faker->text(35),
        'game_uid' => AbinaChess\Game::random()->uid
    ];
});
