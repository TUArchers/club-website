<?php

namespace TuaWebsite\Domain\Identity;

/**
 * Permission Repository Interface
 *
 * @package TuaWebsite\Domain\Identity
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
interface PermissionRepositoryInterface
{
    /**
     * @param Permission $permission
     */
    public function add(Permission $permission);

    /**
     * @param Permission $permission
     */
    public function update(Permission $permission);

    /**
     * @param int $permission_id
     *
     * @return Permission
     */
    public function get($permission_id);

    /**
     * @param string $permission_slug
     *
     * @return Permission
     */
    public function withSlug($permission_slug);
}