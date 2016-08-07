<?php
namespace AbinaChess;

use Illuminate\Database\Eloquent\Model;

class Shout extends Model
{
    //
    public static function getGameShouts($game)
    {
        return self::where('uid',$game->uid)->get();
    }

    public function game()
    {
        return $this->belongsTo('AbinaChess\Game', 'game_uid', 'uid');
    }
}
