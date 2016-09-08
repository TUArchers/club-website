<?php

namespace TuaWebsite\Domain\Event;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Event Type
 *
 * @package TuaWebsite\Model\Events
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventType extends Model
{
    /** Properties */
    protected $fillable = [
        'name',
        'slug',
        'colour_hex',
        'icon_name',
    ];

    /** Methods */
    /**
     * Plan an event of this type
     *
     * @param string      $name
     * @param string|null $description
     * @param string|null $picture_url
     * @param int         $starts_at
     * @param int|null    $ends_at
     * @param string      $location_name
     * @param float|null  $location_longitude
     * @param float|null  $location_latitude
     * @param int         $capacity
     * @param string      $privacy
     * @param bool        $has_waiting_list
     *
     * @return Event
     */
    public function plan($name, $description = null, $picture_url = null, $starts_at, $ends_at = null, $location_name, $location_longitude = null, $location_latitude = null, $capacity = 1, $privacy = Event::P_CLUB, $has_waiting_list = false)
    {
        // Prepare given attributes
        $attributes = compact(
            'name',
            'description',
            'picture_url',
            'location_name',
            'location_longitude',
            'location_latitude',
            'capacity',
            'privacy',
            'has_waiting_list'
        );

        // Add derived attributes and handle date/times
        $attributes['type_id']   = $this->id;
        $attributes['starts_at'] = Carbon::parse($starts_at);
        $attributes['ends_at']   = $ends_at? Carbon::parse($starts_at) : null;

        // Make the event
        $event = new Event($attributes);

        return $event;
    }
}
