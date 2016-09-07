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
     * Register for this event
     *
     * @param string|User $nameOrUser
     * @param string|null $email_address
     * @param string|null $phone_number
     *
     * @return Attendee
     * @throws \Exception
     */
    public function register($nameOrUser, $email_address = null, $phone_number = null)
    {
        // Prepare attributes
        $attributes = [
            'event_id' => $this->id,
        ];

        // Derive properties from a given User instance
        if($nameOrUser instanceof User){
            $attributes['user_id']       = $nameOrUser->id;
            $attributes['name']          = $nameOrUser->name;
            $attributes['email_address'] = $nameOrUser->email_address;
            $attributes['phone_number']  = $nameOrUser->phone_number;
        }
        // Use explicit properties
        elseif(is_string($nameOrUser) && is_string($email_address) && is_string($phone_number)){
            $attributes['name']          = $nameOrUser;
            $attributes['email_address'] = $email_address;
            $attributes['phone_number']  = $phone_number;
        }
        // Bad parameters, bail!
        else{
            throw new \Exception('Bad parameters provided to ' . __METHOD__);
        }

        // Make the attendee
        $attendee = new Attendee($attributes);

        return $attendee;
    }
}
