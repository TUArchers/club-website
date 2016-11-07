<?php
namespace TuaWebsite\Domain\Identity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use TuaWebsite\Domain\Event\Reservation;
use TuaWebsite\Notifications\PasswordChangedNotification;
use TuaWebsite\Notifications\ResetPasswordNotification;

/**
 * User Model
 *
 * @package TuaWebsite\Model\Identity
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 * @since   0.3.0 Added a relationship to EmergencyContact
 *
 * @property int                     $id
 * @property string                  $first_name
 * @property string                  $last_name
 * @property string                  $name
 * @property string                  $gender
 * @property Carbon                  $birth_date
 * @property string                  $picture_url
 * @property bool                    $is_student
 * @property string                  $tusc_id
 * @property string                  $agb_id
 * @property ExperienceLevel         $experienceLevel
 * @property string                  $phone
 * @property string                  $email
 * @property bool                    $email_verified
 * @property string                  $password_hash
 * @property string                  $remember_token
 * @property Carbon                  $registered_at
 * @property Carbon                  $created_at
 * @property Carbon                  $updated_at
 * @property Role                    $role
 * @property EmergencyContact        $emergencyContact
 * @property Membership[]|Collection $memberships
 */
class User extends Authenticatable
{
    use Notifiable;

    // Settings ----
    public $timestamps  = true;
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'gender',
        'birth_date',
        'picture_url',
        'is_student',
        'tusc_id',
        'agb_id',
        'experience_level',
        'phone',
        'email',
        'password_hash',
        'registered_at'
    ];
    protected $hidden   = [
        'password_hash',
        'remember_token',
    ];
    protected $dates    = [
        'birth_date',
        'registered_at',
        'created_at',
        'updated_at'
    ];

    /** @inheritdoc */
    public static function boot()
    {
        parent::boot();

        static::deleting(function(User $user){
            /** @var Reservation $reservations */
            $reservations = Reservation::where('attendee_id', $user->id)->get();

            foreach($reservations as $reservation){
                $reservation->attendee()->dissociate();
                $reservation->save();
            }
        });
    }

    // Relationships ----
    /**
     * @return BelongsTo|Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return HasOne|EmergencyContact
     */
    public function emergencyContact()
    {
        return $this->hasOne(EmergencyContact::class);
    }

    /**
     * @return HasMany|Collection|Membership[]
     */
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    // Accessors ----
    /**
     * Get the full name of this user
     *
     * @return string
     */
    public function getNameAttribute()
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
        if(is_null($this->birth_date)){
            return null;
        }

        return $this->birth_date
            ->diffInYears(Carbon::now());
    }

    /**
     * Get this user's gender
     *
     * @return Gender
     */
    public function getGenderAttribute()
    {
        return Gender::find($this->attributes['gender']);
    }

    /**
     * Get this user's experience level
     *
     * @return ExperienceLevel
     */
    public function getExperienceLevelAttribute()
    {
        return ExperienceLevel::find($this->attributes['experience_level']);
    }

    // Authentication ----
    /** @inheritDoc */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /** @inheritdoc */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new ResetPasswordNotification($token)
        );
    }

    /**
     * Inform this user that their password has been changed
     */
    public function sendPasswordChangedNotification()
    {
        $this->notify(
            new PasswordChangedNotification()
        );
    }

    // Methods ----
    /**
     * Reset this user's password
     *
     * @param string $new_password_hash
     * @param string $remember_token
     *
     * @return User
     */
    public function resetPassword($new_password_hash, $remember_token)
    {
        $this->password_hash  = $new_password_hash;
        $this->remember_token = $remember_token;

        return $this;
    }

}
