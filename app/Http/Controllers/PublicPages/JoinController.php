<?php

namespace TuaWebsite\Http\Controllers\PublicPages;

use Carbon\Carbon;
use Illuminate\Http\Request;
use TuaWebsite\Http\Controllers\Controller;
use TuaWebsite\Model\Events\Attendee;
use TuaWebsite\Model\Events\Event;
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

        $attendee = $event->reserveSpace();
        $attendee->save();

        return View::make('public.taster.reserve', [
            'event_id'    => $event->id,
            'attendee_id' => $attendee->id,
            'expires_at'  => Carbon::now()->addMinutes(5)->getTimestamp(),
            'event_name'  => $event->name,
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

        /** @var Attendee $attendee */
        $attendee = Attendee::find($data->getInt('attendee_id'));

        // Put together the full name
        $name = trim($data->get('first_name') . ' ' . $data->get('last_name'));

        $attendee->confirm(
            $name,
            $data->get('email_address'),
            $data->getDigits('phone_number')
        );

        $attendee->save();

        return View::make('public.taster.confirm', [
            'event_name' => $attendee->event->name
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
