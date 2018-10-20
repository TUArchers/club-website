<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Illuminate\Http\Request;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\Invite;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Event Invites Controller
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 */
class EventInvitesController extends Controller
{
    // Setup ----
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Actions ----
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invites = Invite::with(['user', 'events'])->get();

        return view('admin.invites.index', compact('invites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $events = Event::inFuture()->get();
        $users  = User::all();

        return view('admin.invites.create', compact('events', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach($request->input('user_ids') as $userId){
            $invite = Invite::create([
                'user_id' => $userId,
                'email'   => User::find($userId)->email,
                'token'   => str_random(),
            ]);

            $invite->events()->attach($request->input('event_ids'));
        }

        return redirect(
            route('admin.event-invites.index')
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
