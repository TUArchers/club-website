<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TuaWebsite\Domain\Identity\Role;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Users Controller (Admin)
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get users
        $users = User::all();

        // Return view
        return \View::make('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user_data = $request->only([
            'email', 'phone', 'first_name', 'last_name', 'role_id', 'tusc_id'
        ]);

        $user_data['password_hash'] = \Hash::make($request->get('password'));
        $user_data['registered_at'] = Carbon::now();

        User::create($user_data);

        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param int  $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int  $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = User::find($id);

        $user->update($request->all());

        return redirect('/admin/users/' . $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        User::destroy($id);

        return redirect('/admin/users');
    }
}
