<?php
namespace TuaWebsite\Services;

use TuaWebsite\Model\Events\Event;
use TuaWebsite\Model\Events\Reservation;
use TuaWebsite\Model\Identity\User;

/**
 * Calendar (Event) Service
 *
 * @package TuaWebsite\Application
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class CalendarService
{
    /**
     * Reserve a space for an event
     *
     * @param int $event_id
     *
     * @return Reservation
     */
    public function reserveEventSpace($event_id)
    {
        /** @var Event $event */
        $event = Event::find($event_id);

        $reservation = $event->reserveSpace();
        $reservation->save();

        return $reservation;
    }

    /**
     * Confirm an event reservation
     *
     * @param int $reservation_id
     * @param int $user_id
     *
     * @return Reservation
     */
    public function confirmEventReservation($reservation_id, $user_id)
    {
        /** @var Reservation $reservation */
        $reservation = Reservation::find($reservation_id);
        /** @var User $attendee */
        $attendee = User::find($user_id);

        $reservation->confirm($attendee);
        $reservation->save();

        return $reservation;
    }
}