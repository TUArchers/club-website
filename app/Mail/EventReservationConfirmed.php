<?php

namespace TuaWebsite\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\Reservation;

/**
 * "Event Reservation Confirmed" Email
 *
 * @package TuaWebsite\Mail
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventReservationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Reservation */
    private $reservation;

    /**
     * Create a new message instance
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return self
     */
    public function build()
    {
        /** @var Event $event */
        $event = $this->reservation->event;

        $first_name  = $this->reservation->attendee->first_name;
        $reference   = 'TUA-E' . $event->id . '-A' . $this->reservation->attendee->id . '-R' . $this->reservation->id;

        $start_time  = $event->starts_at->format('g:ia');
        $start_day   = $event->starts_at->format('j');
        $start_month = $event->starts_at->format('F');
        $location    = $event->location_name;

        return $this->view('mail.events.registrationConfirmed', compact('first_name', 'reference', 'start_time', 'start_day', 'start_month', 'location'));
    }
}
