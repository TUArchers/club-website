<?php

namespace TuaWebsite\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use TuaWebsite\Domain\Event\Invite;
use TuaWebsite\Domain\Identity\User;

/**
 * "Event Invitation" Email
 *
 * @package TuaWebsite\Mail
 * @author
 * @version 0.1.0
 * @since   0.1.0
 */
class EventInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User */
    protected $user;
    /** @var Invite */
    private $invite;
    /** @var string */
    private $message;

    /**
     * Create a new message instance
     *
     * @param User   $user
     * @param Invite $invite
     * @param string $message
     */
    public function __construct(User $user, Invite $invite, $message)
    {
        $this->queue = 'emails';

        $this->user    = $user;
        $this->invite  = $invite;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return self
     */
    public function build()
    {
        return $this->view('mail.events.invitation', [
            'first_name'  => $this->user->first_name,
            'url'         => url('/events', ['token' => $this->invite->token]),
            'expires_at'  => $this->invite->expires_at->format('l jS F \a\t g:ia'),
            'event_count' => $this->invite->events->count(),
            'use_count'   => $this->invite->uses,
            'message'     => $this->message,
        ]);
    }
}
