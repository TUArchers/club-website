<?php

namespace TuaWebsite\Domain\Event;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use TuaWebsite\Domain\Identity\User;

/**
 * Invite
 *
 * @package TuaWebsite\Domain\Event
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 1.0.0
 *
 * @property int                $id
 * @property string             $email
 * @property string             $token
 * @property int                $uses
 * @property int                $uses_remaining
 * @property int                $user_id
 * @property User               $user
 * @property Collection|Event[] $events
 * @property Carbon             $expires_at
 * @property Carbon             $created_at
 * @property Carbon             $updated_at
 */
class Invite extends Model
{
    /** Properties */
    public $timestamps  = true;
    protected $fillable = ['user_id', 'email', 'token', 'uses', 'uses_remaining'];
    protected $dates    = ['created_at', 'updated_at'];

    /** Relationships */
    /**
     * @return BelongsTo|User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany|Event[]
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    /** Accessors */

    /**
     * @return string
     */
    public function getEventNamesAttribute()
    {
        return implode(", ", array_map(function(Event $event){
            return $event->name;
        }, $this->events->all()));
    }

    /**
     * @return Carbon
     */
    public function getExpiresAtAttribute()
    {
        /** @var Event $event */
        $event = $this->events->sortByDesc('starts_at')->first();

        return $event->starts_at
            ->copy()
            ->subMinutes(15);
    }

    /** Commands */

    /**
     * @throws \Exception
     */
    public function useOnce()
    {
        if($this->uses_remaining < 2){
            $this->events()->detach();
            $this->delete();
        }
        else{
            $this->decrement('uses_remaining');
        }
    }
}
