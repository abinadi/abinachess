<?php
namespace AbinaChess;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 * @property string shout
 * @property string game_uid
 */
class Shout extends Model
{
    public static function getGameShouts($game)
    {
        return self::where('uid', $game->uid)->get();
    }

    public function game()
    {
        return $this->belongsTo('AbinaChess\Game', 'game_uid', 'uid');
    }
}
