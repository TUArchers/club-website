<?php

namespace TuaWebsite\Http\Controllers\PublicPages;

use Carbon\Carbon;
use Illuminate\Http\Request;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Model\Events\Attendee;
use TuaWebsite\Model\Events\Event;
use TuaWebsite\Model\Events\Reservation;
use View;

/**
 * Join Controller
 *
 * @package TuaWebsite\Http\Controllers\PublicPages
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class JoinController extends Controller
{
    // Actions ----
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function join()
    {
        return View::make('public.join');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function showTasterBookingForm()
    {
        return View::make('public.taster.choose', [
            'events' => $this->findAvailableEvents(1)
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function reserveTasterSpace(Request $request)
    {
        // Get the data from the request
        $data = $request->request;

        /** @var Event $event */
        $event = Event::find($data->getInt('event_id'));

        $reservation = $event->reserveSpace();
        $reservation->save();

        return View::make('public.taster.reserve', [
            'event_id'       => $event->id,
            'event_name'     => $event->name,
            'reservation_id' => $reservation->id,
            'expires_at'     => $reservation->expires_at,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function confirmTasterBooking(Request $request)
    {
        // Get the data from the request
        $data = $request->request;

        /** @var Reservation $reservation */
        $reservation = Reservation::find($data->getInt('reservation_id'));

        // Construct attendee
        $attendee = new Attendee([
            'first_name'    => $data->get('first_name'),
            'last_name'     => $data->get('last_name'),
            'email_address' => $data->get('email_address'),
            'phone_number'  => $data->get('phone_number')
        ]);
        $attendee->save();

        // Confirm the reservation
        $reservation->confirm($attendee);
        $reservation->save();

        return View::make('public.taster.confirm', [
            'event_name' => $reservation->event->name
        ]);
    }

    public function showTasterBookingChangeForm()
    {
        //
    }

    public function confirmTasterBookingChange()
    {
        //
    }

    // Internals ----
    /**
     * @param int $typeId
     *
     * @return Event[]
     */
    private function findAvailableEvents($typeId)
    {
        return Event::where([
            ['type_id', '=', $typeId],
            ['starts_at', '>', Carbon::now()],
        ])->get();
    }
}
