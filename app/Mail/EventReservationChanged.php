<?php

namespace TuaWebsite\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\Reservation;

/**
 * "Event Reservation Changed" Email
 *
 * @package TuaWebsite\Mail
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventReservationChanged extends Mailable
{
    use Queueable, SerializesModels;

    /** @var Reservation */
    private $reservation;
    /** @var string */
    private $message;

    /**
     * Create a new message instance
     *
     * @param Reservation $reservation
     * @param string      $message
     */
    public function __construct(Reservation $reservation, $message)
    {
        $this->reservation = $reservation;
        $this->message     = $message;
        $this->queue       = 'emails';
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

        $details        = $event->description;
        $arrival_time   = $event->starts_at->copy()->subMinutes(15)->format('g:ia');
        $start_time     = $event->starts_at->format('g:ia');
        $start_day      = $event->starts_at->format('j');
        $start_month    = $event->starts_at->format('F');
        $location       = $event->location_name;
        $update_message = $this->message;

        return $this->view('mail.events.change', compact('first_name', 'reference', 'details', 'arrival_time', 'start_time', 'start_day', 'start_month', 'location', 'update_message'));
    }
}
