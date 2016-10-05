<?php

namespace TuaWebsite\Domain\Identity;

/**
 * User Repository Interface
 *
 * @package TuaWebsite\Domain\Identity
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface UserRepositoryInterface
{
    /**
     * @param User $user
     */
    public function add(User $user);

    /**
     * @param User $user
     */
    public function update(User $user);

    /**
     * @param int $user_id
     *
     * @return User
     */
    public function get($user_id);

    /**
     * @param string $email
     *
     * @return bool
     */
    public function existsWithEmailAddress($email);
}