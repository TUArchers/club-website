<?php
namespace TuaWebsite\Model\Identity;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * User
 *
 * @package TuaWebsite\Model
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class User extends Authenticatable
{
    #use Notifiable;

    /** @var array */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'picture_url',
        'tusc_id',
        'is_student',
        'agb_id',
        'email_address',
        'password_hash',
        'registered_at'
    ];
    /** @var array  */
    protected $hidden = [
        'password_hash',
        'remember_token',
    ];
}
