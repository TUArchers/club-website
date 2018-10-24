<?php

namespace TuaWebsite\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Mail\Mailer as MailerContract;
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

    /** @var Carbon */
    private $eventStartsAt;
    /** @var Reservation */
    private $reservation;

    /**
     * Create a new message instance
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->queue         = 'emails';

        $this->eventStartsAt = $reservation->event->starts_at->copy();
        $this->reservation   = $reservation;
    }

    /**
     * @inheritdoc
     */
    public function send(MailerContract $mailer)
    {
        // Don't send this email if the event was rescheduled or cancelled
        $event         = $this->reservation->event;
        $isRescheduled = !$this->eventStartsAt->eq($event->starts_at);
        $isCancelled   = $event->isCancelled();

        if($isRescheduled || $isCancelled){
            return;
        }

        parent::send($mailer);
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

        $first_name  = $this->reservation->attendee->first_name;
        $reference   = 'TUA-E' . $event->id . '-A' . $this->reservation->attendee->id . '-R' . $this->reservation->id;

        $details      = $event->description;
        $arrival_time = $event->starts_at->copy()->subMinutes(15)->format('g:ia');
        $start_time   = $event->starts_at->format('g:ia');
        $start_day    = $event->starts_at->format('j');
        $start_month  = $event->starts_at->format('F');
        $location     = $event->location_name;

        return $this->view('mail.events.reminder', compact('first_name', 'reference', 'details', 'arrival_time', 'start_time', 'start_day', 'start_month', 'location'));
    }
}
