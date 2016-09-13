<?php

namespace TuaWebsite\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use TuaWebsite\Domain\Event\Event;
use TuaWebsite\Domain\Event\Reservation;

/**
 * "Event Reservation Reminder" Email
 *
 * @package TuaWebsite\Mail
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventReservationReminder extends Mailable
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
     * @return $this
     */
    public function build()
    {
        /** @var Event $event */
        $event = $this->reservation->event;

        /** @var Carbon $starts_at */
        $starts_at = $event->starts_at;
        $arrive_at = $starts_at->subMinutes(15);
        $venue     = $event->location_name;

        return $this->view('mail.events.reminder', compact('venue', 'arrive_at', 'starts_at'));
    }
}
