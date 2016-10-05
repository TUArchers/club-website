<?php
namespace TuaWebsite\Domain\Identity;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Role Model
 *
 * @package TuaWebsite\Model\Identity
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 *
 * @property int                     $id
 * @property string                  $name
 * @property string                  $slug
 * @property bool                    $has_full_access
 * @property Carbon                  $created_at
 * @property Carbon                  $updated_at
 * @property Role                    $parent
 * @property Collection|Permission[] $permissions
 */
class Role extends Model
{
    // Settings ----
    public $timestamps  = true;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'has_full_access',
        'parent_id'
    ];
    protected $dates    = [
        'created_at',
        'updated_at'
    ];

    /** @inheritdoc */
    public static function boot()
    {
        parent::boot();

        static::deleting(function(Role $role){
            $role->parent()->dissociate();
            $role->permissions()->detach();
        });
    }

    // Relationships ----
    /**
     * Get the role that this one inherits from
     *
     * @return BelongsTo|Role|null
     */
    public function parent()
    {
        return $this->belongsTo(self::class);
    }

    /**
     * Get the permissions that have been directly assigned to this role
     *
     * @return BelongsToMany|Collection|Permission[]
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    // Accessors ----
    public function getHasParentAttribute()
    {
        return !is_null($this->parent_id);
    }

    /**
     * Get all permissions given to this role, including those inherited
     *
     * @return Collection|Permission[]
     */
    public function getAllPermissionsAttribute()
    {
        // Check for inherited permissions and merge them in
        if($this->has_parent){
            return $this->permissions->merge(
                $this->parent->all_permissions
            );
        }

        return $this->permissions;
    }

    // Queries ----
    /**
     * Check if this role has a permission assigned to it or inherited from a parent role
     *
     * @param Permission $permission
     *
     * @return bool
     */
    public function hasPermission(Permission $permission)
    {
        /** @var Collection|Permission[] $permissions */
        $permissions = $this->all_permissions;

        return $permissions->contains($permission);
    }

    /**
     * Check if this role has a permission directly assigned to it
     *
     * @param Permission $permission
     *
     * @return bool
     */
    public function hasAssignedPermission(Permission $permission)
    {
        /** @var Collection|Permission[] $assignedPermissions */
        $assignedPermissions = $this->permissions;

        return $assignedPermissions->contains($permission);
    }

    /**
     * Check if this role has a permission inherited from parent role
     *
     * @param Permission $permission
     *
     * @return bool
     */
    public function hasInheritedPermission(Permission $permission)
    {
        if(!$this->has_parent){
            return false;
        }

        /** @var Collection|Permission[] $inheritedPermissions */
        $inheritedPermissions = $this->parent->all_permissions;

        return $inheritedPermissions->contains($permission);
    }

}
