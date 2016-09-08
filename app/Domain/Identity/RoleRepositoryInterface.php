<?php

namespace TuaWebsite\Domain\Identity;

/**
 * Role Repository Interface
 *
 * @package TuaWebsite\Domain\Identity
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface RoleRepositoryInterface
{
    /**
     * @param Role $role
     */
    public function add(Role $role);

    /**
     * @param Role $role
     */
    public function update(Role $role);

    /**
     * @param int $role_id
     *
     * @return Role
     */
    public function get($role_id);

    /**
     * @param string $role_slug
     *
     * @return Role
     */
    public function withSlug($role_slug);
}