<?php
namespace TuaWebsite\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\EventType;
use TuaWebsite\Domain\Event\Reservation;
use TuaWebsite\Http\Controllers\Controller;

/**
 * EventsController
 *
 * @package TuaWebsite\Http\Controllers\Admin
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0 Introduced this class
 * @since   0.3.0 Enabled event planning
 */
class EventsController extends Controller
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
     * @return Response
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
     * @return Response
     */
    public function create()
    {
        $action      = route('admin.events.store');
        $event_types = EventType::all();

        return view('admin.events.create', compact('action', 'event_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $event_data = $request->only(['type_id', 'name', 'location_name', 'starts_at', 'ends_at', 'capacity', 'description']);

        $event_data['has_waiting_list'] = $request->has('has_waiting_list');
        $event_data['members_only']     = $request->has('members_only');
        $event_data['invite_only']      = $request->has('invite_only');

        // Handle date/time without seconds
        $event_data['starts_at'] = Carbon::parse($event_data['starts_at'] . ':00');
        if($event_data['ends_at']){
            $event_data['ends_at'] = Carbon::parse($event_data['ends_at'] . ':00');
        }

        $event = Event::create($event_data);

        return redirect(
            route('admin.events.show', $event->id)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $event        = Event::find($id);
        $reservations = $event->reservations->sortBy('attendee.name');

        return view('admin.events.show', compact('event', 'reservations'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

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
