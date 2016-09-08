<?php

namespace TuaWebsite\Model\Events;

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
    public $timestamps  = true;
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email_address',
        'phone_number'
    ];
    protected $dates    = [
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
     * Get the full name of this attendee
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim(
            sprintf('%s %s', $this->first_name, $this->last_name)
        );
    }
}
