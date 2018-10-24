<?php

namespace TuaWebsite\Domain\Event;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TuaWebsite\Domain\Identity\User;

/**
 * Reservation
 *
 * @package TuaWebsite\Model\Events
 * @author
 * @version 0.1.0
 * @since   0.1.0
 *
 * @property Event $event
 */
class Reservation extends Model
{
    /** Properties */
    public $timestamps  = true;
    protected $fillable = [
        'event_id',
        'expires_at',
    ];
    protected $dates    = [
        'created_at',
        'updated_at',
        'expires_at',
        'confirmed_at',
        'cancelled_at',
        'used_at',
    ];

    /** Relationships */
    /**
     * @return BelongsTo|Event
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsTo|User|null
     */
    public function attendee()
    {
        return $this->belongsTo(User::class);
    }

    /** Accessors */
    /**
     * @return bool
     */
    public function getHasExpiredAttribute()
    {
        if(is_null($this->expires_at)){
            return false;
        }

        return Carbon::now()->gte($this->expires_at);
    }

    /**
     * @return bool
     */
    public function getIsConfirmedAttribute()
    {
        return !is_null($this->confirmed_at);
    }

    /**
     * @return bool
     */
    public function getIsCancelledAttribute()
    {
        return !is_null($this->cancelled_at);
    }

    /**
     * @return bool
     */
    public function getIsUsedAttribute()
    {
        return !is_null($this->used_at);
    }

    /** Methods */
    /**
     * Confirm this reservation
     *
     * @param User $attendee
     */
    public function confirm(User $attendee)
    {
        // TODO: This needs to throw an exception that can be shown as an error message
        if($this->is_confirmed || $this->has_expired){
            return;
        }

        $this->expires_at   = null;
        $this->attendee_id  = $attendee->id;
        $this->confirmed_at = Carbon::now();
    }

    /**
     * Cancel this reservation
     */
    public function cancel()
    {
        // TODO: This needs to throw an exception that can be shown as an error message
        if(!$this->is_confirmed){
            return;
        }

        $this->cancelled_at = Carbon::now();
    }

    /**
     * Use this reservation (mark the attendee as having turned up)
     */
    public function markUsed()
    {
        // TODO: This needs to throw an exception that can be shown as an error message
        if(!$this->is_confirmed){
            return;
        }

        $this->used_at = Carbon::now();
    }
}
