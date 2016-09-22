<?php

namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Http\Controllers\Controller;

/**
 * Events Controller
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $now       = Carbon::now();
        $next_week = Carbon::now()->next(Carbon::MONDAY)->startOfWeek();
        $future    = (clone $next_week)->addWeek();

        $events_today = Event::whereDate('starts_at', $now->day)->get();
        $events_week  = Event::whereBetween('starts_at', [$next_week, $future])->get();
        $events_all   = Event::where('starts_at', '>=', $future)->get();

        return view('admin.events.index', compact('events_today', 'events_week', 'events_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event        = Event::find($id);
        $reservations = $event->reservations->sortBy('attendee.full_name');

        return view('admin.events.show', compact('event', 'reservations'));
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
