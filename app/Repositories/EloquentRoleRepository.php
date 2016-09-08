<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Identity\Role;
use TuaWebsite\Domain\Identity\RoleRepositoryInterface;

/**
 * Role Repository
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentRoleRepository implements RoleRepositoryInterface
{
    /** @inheritDoc */
    public function add(Role $role)
    {
        $role->save();
    }

    /** @inheritDoc */
    public function update(Role $role)
    {
        $role->save();
    }

    /** @inheritDoc */
    public function get($role_id)
    {
        return Role::find($role_id);
    }

    /** @inheritDoc */
    public function withSlug($role_slug)
    {
        return Role::where('slug', $role_slug)->first();
    }
}