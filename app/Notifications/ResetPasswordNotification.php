<?php

namespace TuaWebsite\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TuaWebsite\Domain\Identity\User;

/**
 * "Reset Password" Notification
 *
 * @package TuaWebsite\Notifications
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var string */
    private $token;

    /**
     * Create a new notification instance.
     *
     * @param string $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    // Methods ----
    /**
     * Get the notification's delivery channels.
     *
     * @param User $notifiable
     *
     * @return array
     */
    public function via(User $notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param User $notifiable
     *
     * @return MailMessage
     */
    public function toMail(User $notifiable)
    {
        return (new MailMessage)
            ->greeting('Hi ' . $notifiable->first_name)
            ->line('It looks like you lost your password. Let\'s fix that!')
            ->line('Use the link below within an hour to reset your password.')
            ->action('Reset Password', route('auth.password-reset.show', $this->token))
            ->line('If your link has expired, just go to ' . route('auth.password-reset-request.show') . ' to get a new one.');
    }
}
