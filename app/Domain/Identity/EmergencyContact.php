<?php
namespace TuaWebsite\Domain\Identity;

use Illuminate\Database\Eloquent\Model;

/**
 * Emergency Contact
 *
 * @package TuaWebsite\Domain\Identity
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.3.0 Introduced this class
 */
class EmergencyContact extends Model
{
    // Settings ----
    public $timestamps  = true;
    protected $fillable = [
        'user_id',
        'relationship',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address'
    ];
    protected $dates    = [
        'created_at',
        'updated_at'
    ];

    // Accessors ----
    /**
     * Get the full concatenated name for this contact
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return trim(
            sprintf('%s %s', $this->attributes['first_name'], $this->attributes['last_name'])
        );
    }
}
