<?php

namespace TuaWebsite\Model\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TuaWebsite\Model\Identity\User;

/**
 * Attendee
 *
 * @package TuaWebsite\Model\Events
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class Attendee extends Model
{
    #use Notifiable;

    /** Properties */
    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email_address',
        'phone_number',
    ];
    protected $dates = [
        'registered_at',
        'cancelled_at',
        'attended_at',
        'created_at',
        'updated_at',
    ];

    /** Relationships */
    /**
     * @return BelongsTo|User|null
     */
    public function user()
    {
        return $this->belongsTo('TuaWebsite\Model\Identity\User');
    }

    /** Accessors */
    /**
     * Check if this attendee is a club member
     *
     * @return bool
     */
    public function isClubMember()
    {
        return !is_null($this->user_id);
    }

    /**
     * Check if this attendee has confirmed their place
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return !$this->is_provisional && !is_null($this->registered_at);
    }

    /**
     * Check if this attendee is on the waiting list
     *
     * @return bool
     */
    public function isWaiting()
    {
        return $this->is_waiting;
    }

    /**
     * Check if this attendee has cancelled their spot
     *
     * @return bool
     */
    public function hasCancelled()
    {
        return !is_null($this->cancelled_at);
    }

    /** Methods */
    /**
     * Confirm this attendee's spot
     */
    public function confirm()
    {
        if(!$this->isConfirmed()){
            return;
        }

        $this->is_provisional = false;
        $this->registered_at  = Carbon::now();
    }

    /**
     * Cancel this attendee's spot
     */
    public function cancel()
    {
        if(!$this->isConfirmed()){
            return;
        }

        $this->cancelled_at = Carbon::now();

        // Notify attendee
        // TODO: Notify attendee
    }

    /**
     * Register that the attendee has actually shown up
     */
    public function registerAttendance()
    {
        if(!$this->isConfirmed()){
            return;
        }

        $this->attended_at = Carbon::now();
    }
}
