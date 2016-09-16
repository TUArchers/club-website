<?php

namespace TuaWebsite\Http\Controllers\Admin;

use Illuminate\Http\Request;
use TuaWebsite\Domain\Identity\Permission;
use TuaWebsite\Domain\Identity\Role;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Roles Controller
 *
 * @package TuaWebsite\Http\Controllers
 */
class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission_groups = Permission::all()->groupBy('group');
        $other_roles       = Role::where([
            ['has_full_access', false] #TODO: This filters out roles with full access marked as it's pointless inheriting from them
        ])->get();

        return view('admin.roles.create', compact('permission_groups', 'other_roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role_data                    = $request->only('name', 'description');
        $role_data['slug']            = str_slug($role_data['name']);
        $role_data['has_full_access'] = $request->has('has_full_access');

        $role = Role::create($role_data);

        if(!$request->has('has_full_access')){
            $role->parent_id = $request->get('parent_id');

            if($request->has('permissions')){
                $role->permissions()->sync($request->get('permissions'));
            }
        }

        $role->save();

        return redirect(
            route('admin.roles.index')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(405);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role              = Role::findOrFail($id);
        $permission_groups = Permission::all()->groupBy('group');
        $other_roles       = Role::where([
            ['id', '!=', $id],
            ['has_full_access', false] #TODO: This filters out roles with full access marked as it's pointless inheriting from them
        ])->get();

        return view('admin.roles.edit', compact('role', 'permission_groups', 'other_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Role $role */
        $role = Role::find($id);

        $role_data                    = $request->only('name', 'description');
        $role_data['slug']            = str_slug($role_data['name']);
        $role_data['has_full_access'] = $request->has('has_full_access');

        $role->fill($role_data);

        if(!$request->has('has_full_access')){
            $role->parent_id = $request->get('parent_id');

            if($request->has('permissions')){
                $role->permissions()->sync($request->get('permissions'));
            }
        }

        $role->save();

        return redirect(
            route('admin.roles.index')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);

        return redirect(
            route('admin.roles.index')
        );
    }
}
