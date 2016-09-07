<?php

namespace TuaWebsite\Model\Events;

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
}
