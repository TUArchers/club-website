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

    /**
     * Create a new message instance
     *
     * @param User   $user
     * @param Invite $invite
     */
    public function __construct(User $user, Invite $invite)
    {
        $this->queue = 'emails';

        $this->user   = $user;
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return self
     */
    public function build()
    {
        return $this->view('mail.events.invitation', []);
    }
}
