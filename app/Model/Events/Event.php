<?php

namespace TuaWebsite\Model\Events;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TuaWebsite\Model\Identity\User;

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
    /** Constants */
    const P_PUBLIC  = 'P';
    const P_CLUB    = 'C';
    const P_PRIVATE = 'I';

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
     * @return HasMany|Attendee[]
     */
    public function attendees()
    {
        return $this->hasMany('TuaWebsite\Model\Events\Attendee');
    }

    /**
     * @return BelongsTo|EventType
     */
    public function type()
    {
        return $this->belongsTo('TuaWebsite\Model\Events\EventType');
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
        $this->load(['attendees' => function($query){
            $query->where('cancelled_at', null);
        }]);

        $taken = $this->attendees->count();

        return $this->capacity - $taken;
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
     * This is usually used for the taster session booking process
     *
     * @return Attendee
     * @throws \Exception
     */
    public function reserveSpace()
    {
        if($this->is_full){
            throw new \Exception('This event is full');
        }

        // Make a dummy attendee
        $attendee = new Attendee([
            'event_id'      => $this->id,
            'name'          => 'Reserved Space',
            'email_address' => 'events@tuarchers.org.uk',
            'phone_number'  => 'Unknown'
        ]);

        return $attendee;
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
        // Make the attendee
        $attendee = new Attendee([
            'event_id'      => $this->id,
            'user_id'       => $user->id,
            'name'          => $user->full_name,
            'email_address' => $user->email_address,
            'phone_number'  => $user->phone_number
        ]);

        // Confirm
        $attendee->registered_at = Carbon::now();

        return $attendee;
    }
}
