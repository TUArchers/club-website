<?php
namespace TuaWebsite\Domain\Identity;

use Illuminate\Database\Eloquent\Model;

/**
 * Permission Model
 *
 * @package TuaWebsite\Model
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 *
 * @property int    $id
 * @property string $name
 * @property string $slug
 * @property string $group
 */
class Permission extends Model
{
    // Settings ----
    public $timestamps  = false;
    protected $fillable = [
        'name',
        'slug',
        'group',
    ];
}
