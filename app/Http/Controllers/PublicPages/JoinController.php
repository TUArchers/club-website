<?php

namespace TuaWebsite\Http\Controllers\PublicPages;

use Illuminate\Http\Request;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Model\Events\Attendee;
use TuaWebsite\Model\Events\Event;
use TuaWebsite\Services\CalendarService;
use TuaWebsite\Services\IdentityService;
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
    // Setup ----
    /** @var IdentityService $identityService */
    private $identityService;
    /** @var CalendarService */
    private $calendarService;

    /**
     * JoinController constructor.
     *
     * @param IdentityService $identityService
     * @param CalendarService $calendarService
     */
    public function __construct(IdentityService $identityService, CalendarService $calendarService)
    {
        $this->identityService = $identityService;
        $this->calendarService = $calendarService;
    }

    // Actions ----
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function showJoin()
    {
        return View::make('public.join');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function showChooseTaster()
    {
        return View::make('public.taster.choose', [
            'events' => Event::openToPublic()->inFuture()->get()
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function postReserveTasterSpace(Request $request)
    {
        // Get the data from the request
        $data = $request->request;

        $reservation = $this->calendarService->reserveEventSpace(
            $data->getInt('event_id')
        );

        return View::make('public.taster.reserve', [
            'event_id'       => $reservation->event->id,
            'event_name'     => $reservation->event->name,
            'reservation_id' => $reservation->id,
            'expires_at'     => $reservation->expires_at,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function postConfirmTasterBooking(Request $request)
    {
        // Get the data from the request
        $data = $request->request;

        // Set up a basic user account
        $user = $this->identityService->registerBasicUser(
            $data->get('email_address'),
            $data->get('phone_number'),
            $data->get('first_name'),
            $data->get('last_name')
        );

        // Confirm the reservation
        $reservation = $this->calendarService->confirmEventReservation(
            $data->getInt('reservation_id'),
            $user->id
        );

        return View::make('public.taster.confirm', [
            'event_name' => $reservation->event->name
        ]);
    }

    public function showTasterBookingChangeForm()
    {
        //
    }

    public function postConfirmTasterBookingChange()
    {
        //
    }
}
