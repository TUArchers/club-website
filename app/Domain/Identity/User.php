<?php
namespace TuaWebsite\Domain\Identity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use TuaWebsite\Notifications\ResetPasswordNotification;

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
    use Notifiable;

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

    // Relationships ----
    /**
     * @return BelongsTo|Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

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

    /**
     * Used for emailing
     *
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->email_address;
    }

    /**
     * Used for emailing
     *
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->full_name;
    }

    // Authentication ----
    /** @inheritDoc */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /** @inheritdoc */
    public function getEmailForPasswordReset()
    {
        return $this->email_address;
    }

    /** @inheritdoc */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
