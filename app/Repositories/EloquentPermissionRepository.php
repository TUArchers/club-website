<?php
namespace TuaWebsite\Repositories;

use TuaWebsite\Domain\Identity\Permission;
use TuaWebsite\Domain\Identity\PermissionRepositoryInterface;

/**
 * Permission Repository
 *
 * @package TuaWebsite\Repositories
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EloquentPermissionRepository implements PermissionRepositoryInterface
{
    /** @inheritDoc */
    public function add(Permission $permission)
    {
        $permission->save();
    }

    /** @inheritDoc */
    public function update(Permission $permission)
    {
        $permission->save();
    }

    /** @inheritDoc */
    public function get($permission_id)
    {
        return Permission::find($permission_id);
    }

    /** @inheritDoc */
    public function withSlug($permission_slug)
    {
        return Permission::where('slug', $permission_slug)->first();
    }
}