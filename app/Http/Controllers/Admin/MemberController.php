<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use TuaWebsite\Domain\Identity\Role;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Member Controller
 *
 * For managing club memberships
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class MemberController extends Controller
{
    public function showCreateUserForm()
    {
        $roles = Role::all();

        return view('admin.members.create', compact('roles'));
    }

    public function createUser(Request $request)
    {
        $user_data = $request->only(['email_address', 'phone_number', 'first_name', 'last_name', 'role_id', 'tusc_id']);
        $user_data['password_hash'] = \Hash::make($request->get('password'));
        $user_data['registered_at'] = Carbon::now();

        User::create($user_data);

        return redirect('/admin/members');
    }

    public function modifyMemberDetails(Request $request, $memberId)
    {
        //
    }

    public function listMembers()
    {
        // Get users
        $users = User::all();

        // Return view
        return \View::make('admin.members.list', compact('users'));
    }

    public function showMemberDetails($memberId)
    {
        //
    }

    public function removeMember($memberId)
    {
        //
    }
}