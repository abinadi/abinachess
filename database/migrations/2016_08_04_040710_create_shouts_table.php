<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('shout');
            $table->string('game_uid', 40);
            $table->foreign('game_uid')->references('uid')->on('games');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shouts');
    }
}
