<?php
namespace TuaWebsite\Model\Identity;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User
 *
 * @package TuaWebsite\Model\Identity
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class User extends Authenticatable
{
    #use Notifiable;

    /** Constants */
    const G_UNSPECIFIED = 'U';
    const G_MALE        = 'M';
    const G_FEMALE      = 'F';
    const G_OTHER       = 'O';

    /** Properties */
    public $timestamps  = true;
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'picture_url',
        'tusc_id',
        'is_student',
        'agb_id',
        'phone_number',
        'email_address',
        'password_hash',
        'registered_at'
    ];
    protected $hidden   = [
        'password_hash',
        'remember_token',
    ];
    protected $dates    = [
        'date_of_birth',
        'registered_at',
        'created_at',
        'updated_at'
    ];

    /** Accessors */
    /**
     * Get the full name of this user
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return trim(
            sprintf('%s %s', $this->first_name, $this->last_name)
        );
    }

    /**
     * Get the age of this user
     *
     * @return int|null
     */
    public function getAgeAttribute()
    {
        if(is_null($this->date_of_birth)){
            return null;
        }

        /** @var Carbon $dob */
        $dob = $this->date_of_birth;

        return $dob->diffInYears(Carbon::now());
    }
}
