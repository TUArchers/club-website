<?php

namespace TuaWebsite\Http\Controllers\Kiosk;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\Invite;
use TuaWebsite\Domain\Event\Reservation;
use TuaWebsite\Domain\Identity\User;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Mail\EventReservationConfirmed;
use TuaWebsite\Mail\EventReservationReminder;

/**
 * Events Controller
 *
 * @package TuaWebsite\Http\Controllers\Kiosk
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /** @var Invite $invite */
        $invite = Invite::query()->where('token', $request->input('token'))->first();

        // Bail now if invite not found
        if(!$invite){
            return redirect('/');
        }

        // Extract the user and all applicable events that haven't started yet
        $user       = $invite->user;
        $events     = $invite->events->where('starts_at', '>', new \DateTime());

        // Group the events into days
        $event_days = $events->groupBy(function(Event $event){
            return $event->starts_at->format('l jS F');
        });

        return view('kiosk.bookings', compact('event_days', 'user'));
    }

    // API Actions ----

    /**
     * @param Request $request
     * @param int     $eventId
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function storeReservation(Request $request, $eventId)
    {
        if($request->has('reservation_id')){
            Reservation::destroy($request->get('reservation_id'));
        }

        /** @var Event $event */
        $event       = Event::find($eventId);
        $reservation = $event->reserveSpace();

        $reservation->save();

        return response()->json($reservation->toArray());
    }

    /**
     * @param Request $request
     * @param int $eventId
     * @param int $reservationId
     *
     * @return JsonResponse
     */
    public function updateReservation(Request $request, $eventId, $reservationId)
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::find($reservationId);
        /** @var Event $event */
        $event       = Event::find($eventId);

        // Check reservation is good
        if($reservation->has_expired){
            return response()->json(['message' => 'That reservation has expired'], 408);
        }

        // Get the user account
        $user = User::find($request->input('user_id'));

        // Confirm the reservation
        $reservation->confirm($user);
        $reservation->save();

        // Queue up emails
        $this->queueEmail(new EventReservationConfirmed($reservation), $user);
        $this->queueEmail(new EventReservationReminder($reservation), $user, $event->starts_at->subDays(1));

        return response()->json($reservation->toArray());
    }

    // Internals ----

    /**
     * @param Mailable $email
     * @param User $recipient
     * @param Carbon|null $sendDate
     */
    private function queueEmail(Mailable $email, User $recipient, Carbon $sendDate = null)
    {
        if($sendDate && method_exists($email, 'delay')){
            $delay = $sendDate->diffInSeconds(Carbon::now());
            $email->delay($delay);
        }

        \Mail::to($recipient)->queue($email);
    }
}
