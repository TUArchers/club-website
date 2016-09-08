<?php
namespace TuaWebsite\Services;

use Carbon\Carbon;
use TuaWebsite\Exceptions\UserExistsException;
use TuaWebsite\Model\Identity\Role;
use TuaWebsite\Model\Identity\User;

/**
 * Identity Service
 *
 * @package TuaWebsite\Application
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class IdentityService
{
    // Methods ----
    /**
     * Register a new user
     *
     * Used for making basic user accounts for things like taster sessions
     *
     * @param string $email_address
     * @param string $phone_number
     * @param string $first_name
     * @param string $last_name
     *
     * @throws \Exception
     * @return User
     */
    public function registerBasicUser($email_address, $phone_number, $first_name, $last_name = null)
    {
        // Check if the email address is already in use
        if($this->userWithEmailAddressExists($email_address)){
            throw new UserExistsException('A user with that email address already exists');
        }

        // Prepare user attributes
        $attributes                  = compact('email_address', 'first_name', 'last_name', 'phone_number');
        $attributes['password_hash'] = \Hash::make($this->generatePassword());
        $attributes['role_id']       = Role::where('name', 'Guest')->first()->id;
        $attributes['registered_at'] = Carbon::now();

        // Make the user
        $user = User::create($attributes);

        // TODO: Do stuff here, like queuing up emails to the new user, etc.
        //

        return $user;
    }

    // Internals ----
    /**
     * Check if a user with the given email address already exists
     *
     * @param string $email_address
     *
     * @return bool
     */
    private function userWithEmailAddressExists($email_address)
    {
        return !is_null(
            User::where('email_address', $email_address)->first()
        );
    }

    /**
     * Generate a password
     *
     * @param int $length
     *
     * @return string
     */
    private function generatePassword($length = 10)
    {
        return str_random($length);
    }
}