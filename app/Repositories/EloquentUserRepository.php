<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Domain\Identity\UserRepositoryInterface;

/**
 * User Repository
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentUserRepository implements UserRepositoryInterface
{
    /** @inheritDoc */
    public function add(User $user)
    {
        $user->save();
    }

    /** @inheritDoc */
    public function update(User $user)
    {
        $user->save();
    }

    /** @inheritDoc */
    public function get($user_id)
    {
        return User::find($user_id);
    }

    /** @inheritDoc */
    public function existsWithEmailAddress($email_address)
    {
        return !is_null(
            User::where('email_address', $email_address)->first()
        );
    }

}