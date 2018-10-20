<?php

namespace TuaWebsite\Domain\Event;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Model\Events\Attendee;

/**
 * Event
 *
 * @package TuaWebsite\Model\Events
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class Event extends Model
{
    /** Properties */
    public $timestamps  = true;
    protected $fillable = [
        'type_id',
        'name',
        'description',
        'picture_url',
        'starts_at',
        'ends_at',
        'location_name',
        'location_latitude',
        'location_longitude',
        'capacity',
        'has_waiting_list',
        'members_only',
        'invite_only',
        'privacy',
    ];
    protected $dates    = [
        'starts_at',
        'ends_at',
        'cancelled_at',
        'created_at',
        'updated_at'
    ];

    /** Relationships */
    /**
     * @return BelongsTo|EventType
     */
    public function type()
    {
        return $this->belongsTo(EventType::class);
    }

    /**
     * @return HasMany|Collection|Reservation[]
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * @return HasMany|Collection|Reservation[]
     */
    public function confirmedReservations()
    {
        return $this->reservations()
            ->where('confirmed_at', '!=', null)
            ->where('cancelled_at', '=', null);
    }

    /** Scopes */
    /**
     * Find events that are open to the public
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeOpenToPublic(Builder $query)
    {
        return $query->where([
            ['invite_only', false],
            ['members_only', false]
        ]);
    }

    /**
     * Find events that are due to occur in the future
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeInFuture(Builder $query)
    {
        return $query->where([
            ['starts_at', '>', Carbon::now()]
        ]);
    }

    /**
     * Find events that are due to occur in the next seven days
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeNextSevenDays(Builder $query)
    {
        $now      = Carbon::now();
        $nextWeek = Carbon::now()->addDays(7);

        return $query->whereBetween('starts_at', [$now, $nextWeek]);
    }

    /** Accessors */
    /**
     * Get the duration of this event
     *
     * @return int|null
     */
    public function getDurationAttribute()
    {
        if(is_null($this->ends_at)){
            return null;
        }

        /** @var Carbon $startTime */
        $startTime = $this->starts_at;
        /** @var Carbon $endTime */
        $endTime   = $this->ends_at;

        return $endTime->diffForHumans($startTime, true);
    }

    /**
     * Get the number of spaces left in this event
     *
     * @return int
     */
    public function getSpacesRemainingAttribute()
    {
        return $this->capacity - $this->confirmedReservations()->count();
    }

    /**
     * Check if this event is full
     *
     * @return bool
     */
    public function getIsFullAttribute()
    {
        return $this->spaces_remaining < 1;
    }

    /** Queries */

    /**
     * Check if this is a cancelled event
     *
     * @return bool
     */
    public function isCancelled()
    {
        return !is_null($this->cancelled_at);
    }


    /** Methods */
    /**
     * Cancel this event
     */
    public function cancel()
    {
        // Mark the event as cancelled
        $this->cancelled_at = Carbon::now();
    }

    /**
     * Change the event type
     *
     * @param $typeId
     */
    public function changeType($typeId)
    {
        $this->type_id = (int) $typeId;
    }

    /**
     * Rename this event
     *
     * @param $name
     */
    public function rename($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Describe this event
     *
     * @param $description
     */
    public function describe($description)
    {
        $this->description = (string) $description;
    }

    /**
     * Change the start time and/or end time
     *
     * @param Carbon $startsAt
     * @param Carbon $endsAt
     */
    public function changeTimes(Carbon $startsAt, Carbon $endsAt)
    {
        $this->starts_at = $startsAt;
        $this->ends_at   = $endsAt;

        // Notify attendees
        // TODO: Notify attendees
    }

    /**
     * Change the location of this event
     *
     * @param string     $name
     * @param float|null $longitude
     * @param float|null $latitude
     */
    public function changeLocation($name, $longitude = null, $latitude = null)
    {
        $this->location_name = $name;

        if(!is_null($longitude) && !is_null($latitude)){
            $this->location_longitude = $longitude;
            $this->location_latitude  = $latitude;
        }

        // Notify attendees
        // TODO: Notify attendees
    }

    /**
     * Adjust the capacity of this event
     *
     * @param $capacity
     */
    public function adjustCapacity($capacity)
    {
        if((int) $capacity < $this->reservations()->count()){
            throw new \InvalidArgumentException("New capacity cannot be lower than the number of existing reservations");
        }

        $this->capacity = (int) $capacity;
    }

    /**
     * Change event preferences
     *
     * @param $hasWaitingList
     * @param $isMembersOnly
     * @param $isInviteOnly
     */
    public function changePreferences($hasWaitingList, $isMembersOnly, $isInviteOnly)
    {
        $this->has_waiting_list = (bool) $hasWaitingList;
        $this->is_members_only  = (bool) $isMembersOnly;
        $this->is_invite_only   = (bool) $isInviteOnly;
    }

    /**
     * Reserve a space for this event
     *
     * @return Reservation
     * @throws \Exception
     */
    public function reserveSpace()
    {
        if($this->is_full){
            throw new \Exception('This event is full');
        }

        // Make an anonymous reservation
        $reservation = new Reservation([
            'event_id'   => $this->id,
            'expires_at' => Carbon::now()->addMinutes(5)
        ]);

        return $reservation;
    }

    /**
     * Sign up for this event
     *
     * @param User $user
     *
     * @return Attendee
     * @throws \Exception
     */
    public function register(User $user)
    {
        $reservation = $this->reserveSpace();

        // Make the attendee
        $attendee = new Attendee([
            'user_id'    => $user->id,
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
            'phone'      => $user->phone
        ]);

        // Confirm
        $reservation->confirm($attendee);

        return $attendee;
    }
}
