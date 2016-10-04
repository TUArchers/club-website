<?php

namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\Reservation;
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
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Web Actions ----
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today    = Carbon::today();
        $tomorrow = Carbon::today()->addDay();
        $weekEnd  = Carbon::today()->endOfWeek();

        $events_today = Event::whereDate('starts_at', $today)->get();
        $events_week  = Event::whereBetween('starts_at', [$tomorrow, $weekEnd])->get();
        $events_future = Event::where('starts_at', '>', $weekEnd)->get();

        return view('admin.events.index', compact('events_today', 'events_week', 'events_future'));
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

    // API Actions ----
    /**
     * @param Request $request
     * @param int $eventId
     * @param int $reservationId
     *
     * @return JsonResponse
     */
    public function markReservation(Request $request, $eventId, $reservationId)
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::find($reservationId);

        if($request->has('used')){
            $reservation->markUsed();
            $reservation->save();
        }
        elseif($request->has('cancelled')){
            $reservation->cancel();
            $reservation->save();
        }

        return response()->json([], 204);
    }
}
