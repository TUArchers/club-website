<?php

namespace TuaWebsite\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TuaWebsite\Domain\Identity\User;

/**
 * "Password Changed" Notification
 *
 * @package TuaWebsite\Notifications
 * @author  James Drew <jdrew9@hotmail.co.uk>
 * @version 0.1.0
 * @since   0.1.0
 */
class PasswordChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->queue = 'notifications';
    }

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
            ->greeting('Just letting you know...')
            ->line('Your password has just been changed. If this wasn\'t you or was unexpected, please contact support@tuarchers.org.uk as soon as possible');
    }
}
