<?php

namespace TuaWebsite\Domain\Event;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
     * @return HasMany|Reservation[]
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
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

        return $endTime->diffInMinutes($startTime);
    }

    /**
     * Get the number of spaces left in this event
     *
     * @return int
     */
    public function getSpacesRemainingAttribute()
    {
        $this->load(['reservations' => function($query){
            $query->where('cancelled_at', null);
        }]);

        return $this->capacity - $this->reservations->count();
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

    /** Methods */
    /**
     * Cancel this event
     */
    public function cancel()
    {
        // Mark the event as cancelled
        $this->cancelled_at = Carbon::now();

        // Notify attendees
        // TODO: Notify attendees
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
            'expires_at' => Carbon::now()->addMinutes(3)
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
            'user_id'       => $user->id,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'email_address' => $user->email_address,
            'phone_number'  => $user->phone_number
        ]);

        // Confirm
        $reservation->confirm($attendee);

        return $attendee;
    }
}
