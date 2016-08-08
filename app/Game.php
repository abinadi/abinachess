<?php
namespace AbinaChess;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 *
 * @package AbinaChess
 * @property int id
 * @property string uid
 * @property string black
 * @property string white
 * @property string history
 * @property string pgn
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class Game extends Model
{
    protected $fillable = ['black', 'white'];

    protected $casts = [
        'history' => 'array'
    ];

    public static function boot()
    {
        parent::boot();

        /*
         * Generate a unique UID for each game when the new entry is created.
         * The `generateUid()` method is random, so check for collisions and
         * try again if the UID already exists in the games table.
         */
        static::creating(function ($model) {
            $uid = self::generateUid();

            while (self::uidExists($uid)) {
                $uid = self::generateUid();
            }

            $model->uid = $uid;
        });
    }

    /**
     * @return mixed
     */
    public static function random()
    {
        return self::all()->random(1);
    }

    /**
     * @param $uid
     *
     * @return boolean
     */
    private static function uidExists($uid)
    {
        $game = self::where('uid', $uid)->first();

        return !is_null($game);
    }

    /**
     * @param $uid
     * @return mixed
     */
    public static function getGameOrFail($uid)
    {
        return self::where('uid', $uid)->firstOrFail();
    }

    /**
     * @param $value
     */
    public function setUid($value)
    {
        $this->attributes['uid'] = self::generateUid();
    }

    public function shouts()
    {
        return $this->hasMany('AbinaChess\Shout', 'game_uid', 'uid');
    }

    /**
     * @param int $l
     * @return string
     */
    private static function generateUid($l = 6)
    {
        return substr(str_shuffle("23456789abcdefghijkmnopqrstuvwxyz"), 0, $l);
    }

    /**
     * @param int|null $seed
     * @return string
     */
    private function generateUUid($seed = null)
    {
        if (is_null($seed)) {
            $seed = rand();
        }

        return base_convert($seed, 10, 32);
    }

    /**
     * @param $uuid
     * @return int
     */
    private function decodeUUid($uuid)
    {
        return intval($uuid, 32);
    }
}
